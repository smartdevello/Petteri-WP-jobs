<?php
/* Template Name: JobdetailsTemplate */

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

if (isset($_GET['job_id']))
    $job_id = $_GET['job_id'];


try {
    $xml = new SimpleXMLElement($response);
    $job = null;
    foreach($xml as $key=>$advert)
    {
        if ($advert->id == $job_id){
            $job = $advert;
        }
    }
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
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-10 pt-11">
            <div class="contents text-center">
                <h1 class="contents-title">Kuvaus työpaikasta</h1>
            </div>
        </div>
    </div>
    <div class="mb-9">
        <a class="text-secondary" href="javascript:history.back();">
            <span class="fas fa-arrow-left small text-primary mr-2"></span>
            Takaisin
        </a>
    </div>
    <div class="row justify-content-md-between align-items-center mb-7 space-1">

        <div class="col-md-9 mb-7 mb-md-0">
                <h3><?php echo $job->name; ?></h3>
                <p class="mb-0">
                    <?php echo $job->muncipalities.', ';?>
                    <span class="text-muted m1-2">
                        <?php echo $job->regions; ?>
                    </span>
                </p>

                <p class="mb-0">
                    <span class="text-muted">Työsuhteen muoto:</span>
                    <span class="ml-2"><?php echo $job->typeofworkrelationship; ?></span>
                </p>
                <p class="mb-0">
                    <span class="text-muted">Haku päättyy:</span>
                    <?php
                        $endDay = $job->endDisplay;
                        $endDay = explode(' ', $endDay)[0];
                    ?>
                    <span class="ml-2"><?php echo $endDay; ?></span>
                </p>
                <p class="mb-0">
                    <span class="text-muted">Avoimet paikat:</span>
                    <span class="ml-2"><?php echo $job->numberofperson; ?></span>
                </p>
            </div>
        <div class="col-md-3 text-md-right text-md-center">
                <?php $job_link = "https://lisapalvelu.likeit.fi/apply/". $job->id;?>
                <a class=" btn btn-primary transition-3d-hover" href="<?php echo $job_link; ?>" target="_blank">
                    Hae paikkaa
                </a>
        </div>
    </div>
    <div class="w-lg-80 space-bottom-2 mx-auto">
        <?php echo $job->description; ?>
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

</div>

<?php
get_footer();
?>