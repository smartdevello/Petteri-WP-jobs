<?php
/* Template Name: JobsTemplate */

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://lisapalvelu.likeit.fi/servlet/XML?handler=duuni.Advert&state=-1&loginuser=guest&loginpass=vieras',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Cookie: JSESSIONID=A35FD7A476FA67E143BC87F46E0C4CA6'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
try {
    $xml = new SimpleXMLElement($response);
}
catch( Exception $e ) {
    echo "found an exception: " . $e;
}

get_header();
?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Page level plugin JavaScript--><script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<style>
    .space-1{
        padding-bottom: 2rem;
        padding-top: 2rem;
    }
    #dataTable_wrapper div.row:first-child{
        display: none;
    }
    .btn-primary {
        color: #fff;
        background-color: #39c !important;
        border-color: #39c !important;
    }
    a {
        color: #39c !important;
    }
    .page-item.active .page-link {

        color: #fff !important;
        background-color: #39c !important;
        border-color: #39c !important;
    }
    #dataTable_info{
        display: none;
    }
        .bg-primary {
        background-color: #39c !important;
    }
    .btn-primary {
        background-color: #39c !important;
        border-color: #39c !important;
    }
    .space-2, .space-top-2 {
        padding-top: 4rem !important;
    }
    .mb-7, .my-7 {
        margin-bottom: 3rem !important;
        margin-top: 3rem !important;
    }
</style>

<?php
$cities = array();
$regions = array();
$fieldofworks = array();
$typeofworkrelationships = array();
foreach($xml as $job){
    $single_cites = explode(',', $job->muncipalities);
    foreach($single_cites as $city){
        if ($city == '') continue;
        $city = trim($city, ' ');
        //echo $city. '<br>';
        $cities[$city] = 1;
    }
    $single_region = explode(',', $job->regions);
    foreach($single_region as $region){
        if ($region == '') continue;
        $region = trim($region, ' ');
        //echo $city. '<br>';
        $regions[$region] = 1;
    }
    $field = (string)$job->fieldofwork;
    if ($field !='') {
        $fieldofworks[$field] = 1;
    }

    $single_typeofworkrelationship = explode(',', $job->typeofworkrelationship);
    foreach($single_typeofworkrelationship as $typeofworkrelationship){
        if ($typeofworkrelationship == '') continue;
        $typeofworkrelationship = trim($typeofworkrelationship, ' ');
        //echo $city. '<br>';
        $typeofworkrelationships[$typeofworkrelationship] = 1;
    }


}

?>
    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-10 pt-11">
                <div class="contents text-center">
                    <h1 class="contents-title">Avoimet työpaikat</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row align-items-md-center space-1">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <!-- Jobs Search Field -->
                        <div class="js-focus-state">
                            <label class="sr-only" for="searchJobsSr">Tee haku</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
					<span class="input-group-text" id="searchJobs">
						<span class="fas fa-search"></span>
					</span>
                                </div>
                                <input type="text" class="form-control" name="text" id="searchJobsSr" placeholder="Etsi hakusanalla" aria-label="Etsi hakusanalla" aria-describedby="searchJobs">
                            </div>
                        </div>
                        <!-- End Jobs Search Field -->
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary" id="searchBtn">Hae</button>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-outline-primary" id="reset_button">Nollaa kaikki</button>
                    </div>
                </div>
                <form id="filter_form" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <select id="inputCity" name="inputCity" class="form-control">
                                <option selected="" value="none">Valitse kaupunki...</option>
                                <?php
                                foreach($cities as $key => $value){
                                    ?>
                                    <option value="<?php echo $key;?>">
                                        <?php echo $key;?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputMunicipality" name="inputMunicipality" class="form-control">
                                <option selected="" value="none">Valitse alue...</option>
                                <?php
                                foreach($regions as $key => $value){
                                    ?>
                                    <option value="<?php echo $key;?>">
                                        <?php echo $key;?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputField" name="inputField" class="form-control">
                                <option selected="" value="none">Toimiala...</option>
                                <?php
                                foreach($fieldofworks as $key => $value){
                                    ?>
                                    <option value="<?php echo $key;?>">
                                        <?php echo $key;?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputRelationship" name="inputRelationship" class="form-control">
                                <option selected="" value="none">Työsuhteen muoto...</option>
                                <?php
                                foreach($typeofworkrelationships as $key => $value){
                                    ?>
                                    <option value="<?php echo $key;?>">
                                        <?php echo $key;?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive-sm">
                    <table class="table table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Nimike</th>
                                <th scope="col">Työsuhde</th>
                                <th scope="col">Sijainti</th>
                                <th scope="col">Haku päättyy</th>
                                <th scope="col"></th>
                                <th scope="col" style="display: none;"></th>
                                <th scope="col" style="display: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($xml as $key => $advert){

                                $detail_url = "/jobdetails?job_id=" . $advert->id;
                                $apply_url = "https://lisapalvelu.likeit.fi/apply/". $advert->id;
                                $endDay = $advert->endDisplay;
                                $endDay = explode(' ', $endDay)[0];
                                ?>
                                <tr>
                                  <th scope="row">
                                      <a href="<?php echo $detail_url; ?>"><?php echo $advert->name;?></a>
                                  </th>
                                  <td><?php echo $advert->typeofworkrelationship; ?></td>
                                  <td><?php echo $advert->locations; ?></td>
                                  <td><?php echo $endDay ; ?></td>
                                  <td>
                                      <a href="<?php echo $apply_url; ?>">
                                          <button class="btn btn-xs btn-primary">Hae paikkaa</button>
                                      </a>
                                  </td>
                                  <td style="display: none;">
                                      <?php echo $advert->regions; ?>
                                  </td>
                                  <td style="display: none;">
                                      <?php echo $advert->fieldofworks->string; ?>
                                  </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="w-lg-80 space-top-2 mx-auto">
            <hr class="my-7">
        </div>

        <div class="bg-primary text-white text-center">
            <div class="container space-1">
                <span class="h6 d-block d-lg-inline-block font-weight-light mb-lg-0">
                    <span class="font-weight-semi-bold">Eikö löytynyt mieleistä paikkaa?</span> Täytä avoin hakemus ja pyrimme löytämään sinulle oikeita töitä.
                </span>
                <a class="btn btn-sm btn-white transition-3d-hover font-weight-normal ml-3" style="background: white; color: #39c" href="https://lisapalvelu.likeit.fi/apply/107488" target="_blank">Tee avoin hakemus</a>
            </div>
        </div>

    </div>iv>
    </div>
    <script>
        $(document).ready(function(){
            $('#inputCity option[value="<?php echo isset($_POST['inputCity'])? $_POST['inputCity']: 'none'; ?>"]').prop('selected', true);
            $('#inputMunicipality option[value="<?php echo isset($_POST['inputMunicipality']) ? $_POST['inputMunicipality']: 'none'; ?>"]').prop('selected', true);
            $('#inputField option[value="<?php echo isset($_POST['inputField'])? $_POST['inputField']: 'none'; ?>"]').prop('selected', true);
            $('#inputRelationship option[value="<?php echo isset($_POST['inputRelationship']) ? $_POST['inputRelationship']: 'none'; ?>"]').prop('selected', true);


            var table = $('#dataTable').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                order: [[ 2, 'asc' ], [ 0, 'asc' ]],
                "language": {
                    "paginate": {
                        "previous": "Edelliset",
                        "next": "Seuraavat"
                    }
                },
                "pagingType": "simple_numbers"
            } );

            $('#inputCity').change(function(){
                let keyword = this.value;
                if (keyword == 'none') keyword = '';
                console.log(keyword);
                if ( table.column(2).search() !== keyword ) {
                    table
                        .column(2)
                        .search( keyword)
                        .draw();
                }

                //$('form#filter_form').submit();
            });
            $('#inputMunicipality').change(function(){
                let keyword = this.value;
                if (keyword == 'none') keyword = '';
                console.log(keyword);
                if ( table.column(5).search() !== keyword ) {
                    table
                        .column(5)
                        .search(keyword)
                        .draw();
                }
                // $('form#filter_form').submit();
            });
            $('#inputField').change(function(){
                let keyword = this.value;
                if (keyword == 'none') keyword = '';
                console.log(keyword);
                if ( table.column(6).search() !== keyword ) {
                    table
                        .column(6)
                        .search(keyword)
                        .draw();
                }

                // $('form#filter_form').submit();
            });
            $('#inputRelationship').change(function(){
                let keyword = this.value;
                if (keyword == 'none') keyword = '';
                console.log(keyword);
                if ( table.column(1).search() !== keyword ) {
                    table
                        .column(1)
                        .search(keyword)
                        .draw();
                }
                // $('form#filter_form').submit();
            });
            $('#reset_button').click(function(){
                $('#inputCity option[value="none"]').prop('selected', true);
                $('#inputMunicipality option[value="none"]').prop('selected', true);
                $('#inputField option[value="none"]').prop('selected', true);
                $('#inputRelationship option[value="none"]').prop('selected', true);
                $('form#filter_form').submit();
            });
            var searchJobsstr = "";
            $('#searchJobsSr').keyup(function(){
                if (searchJobsstr != $(this).val()) {
                    searchJobsstr = $(this).val();
                    $('#dataTable_filter input').val(searchJobsstr);
                    $('#dataTable_filter input').trigger('keyup');
                }

            });
            $('#searchBtn').click(function(){
                $('#dataTable_filter input').trigger('keyup');
            });

        });

    </script>
<?php
	get_footer();
?>