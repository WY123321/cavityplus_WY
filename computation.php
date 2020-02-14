<!DOCTYPE html>
<html lang="en">
    
    
<?php

session_start();
$lifeTime = 24 * 3600;
isset($PHPSESSID)?session_id($PHPSESSID):$PHPSESSID = session_id();
setcookie('PHPSESSID', $PHPSESSID, time()+$lifeTime);
$_SESSION['sessws']="user_sess/".str_replace("-","_",date("Y-m-d"))."_".str_replace(":","_",date("h:i:sa"))."_testusers";
$_SESSION['islogin']='yes';
$_SESSION['firstname']= "";
$_SESSION['lastname']= "HelloTest";
$tmpspace=$_SESSION['sessws'];
system("mkdir $tmpspace");
$counter=intval(file_get_contents("resource/counter/counter.log"));
$_SESSION['counter']=$counter;

?>
<?php

if (isset($_SESSION['islogin']) && ($_SESSION['islogin'] == "yes")) {

    $yourname = $_SESSION['lastname'];

} else {
    echo "<script type='text/javascript'>alert('Your account has not been logged in!');location='index.php';
</script>";
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" href="/img/pku_favicon.ico" mce_href="/img/pku_favicon.ico" type="image/x-icon">
    <title>CavityPlus</title>

<!--     <script type="text/javascript" src="./js/semantic.min.js"></script> -->
    <script src="./resource/js/jquery/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style>
    #mainsidebar{
        float: left; width:80%;
    }
    #rightsidebar{
        float:right; width:10%;
    }
    ul.nav-tabs{
        width: 130px;
        margin-top: 20px;
        border-radius: 4px;
        right: 0;
    }
    
    </style>
    <script type='text/javascript'>
        $(document).ready(function () {


            $("#showFrame").show();
            $("#showFrame").attr("src", "./computing.php");
               


        });

        function resizeIframe() {
            var iFrameID = document.getElementById('showFrame');
            if (iFrameID) {
                var cont = iFrameID.contentWindow.document.body || frame.contentDocument.body
                // here you can make the height
                iFrameID.height = cont.scrollHeight + "px";
            }
        }


        window.setInterval("resizeIframe()", 200);
        
     $(document).ready(function(){
        $("#myNav").affix({
            offset: { 
                top: 125 
          }
        });
    });
    </script>

    <!-- side-helper -->
    <script>
        $(function () {
            $(".need-help-component").on("click touch", "#need-help-button", function () {
                toggleClass();
            });
        });

        function handleBtnKeyPress(event) {
            // Check to see if space or enter were pressed
            if (event.keyCode === 32 || event.keyCode === 13) {
                // Prevent the default action to stop scrolling when space is pressed
                event.preventDefault();
                toggleClass();
            }
        }

        function toggleClass() {
            $(".need-help-component").toggleClass("is-open");
            //set the ARIA attributes
            // Check to see if the button is pressed
            var pressed = $("#need-help-button").attr("aria-pressed") === "true"; // Change aria-expanded to the opposite state
            $("#need-help-button").attr("aria-pressed", !pressed);
            //check to see if help group is hidden
            var expanded = $("#need-help-group").attr("aria-expanded") === "true";
            //change aria-hidden to opposite
            $("#need-help-group").attr("aria-expanded", !expanded);
            return false;
        }

        // Dynamic CSS
        var sheet = document.createElement("style");
        sheet.innerHTML =
            ".is-open #need-help-button-text:after { content: 'Close help X'} #need-help-button-text:after {content:'Need Help?';}";
        document.body.appendChild(sheet);

    </script>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic" rel="stylesheet"
          type="text/css">
    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">
    <!-- Side help CSS -->
    <link rel="stylesheet" href="css/scroll.css">
</head>

<body id="page-top" class="index">
<!-- Navigation navbar navbar-default navbar-custom navbar-fixed-top-->
<nav class="navbar-custom-computing">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand page-scroll" href="./index.php">
            <font size='6'>CavityPlus</font>
        </a>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="page-scroll" href="./index.php#about">ABOUT</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./computation.php">Computing</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./computation.php#toolbox">TOOLBOX</a>
                    <div class="dropdown-content">
                        <p><a href="#portfolioModal1" class="portfolio-link"
                              data-toggle="modal">Cavity</a></p>
                        <p><a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">CavPharmer</a></p>
                        <p><a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">Corrsite</a></p>
                        <p><a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">CovCys</a></p>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./tutorial.php">Tutorial</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./index.php#publications">reference</a>
                </li>
                <li class="dropdown">
                    <!--<a class="btn" data-toggle="modal" data-target="#loginFormTest">Log in</a>-->
                    <a class="page-scroll" href="./index.php#contact">Contact Us</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<img src="img/computationHeader.jpg" width="100%"/>
    
<!--     <div class="row">
        <div class="col-xs-10">
            <div class="wrapper cf">
                 <iframe id="showFrame" src="" width="100%" scrolling="no" frameborder="0"
                        onload="resizeIframe()"></iframe>
            </div>
        </div>
        
        <div id="rightsidebar">
    <div class="sidebar">
      <ul class="nav nav-tabs nav-stacked" id="myNav">
        <h3>Learn more</h3>
        <p>----------</p>
        <p><a data-toggle="modal" href="#cavityModule">Cavity Module</a></p>
        <p><a data-toggle="modal" href="#pharmacophoreModule">CavPharmer Module</a></p>
        <p><a data-toggle="modal" href="#corrsiteModule">CorrSite Module</a></p>
        <p><a data-toggle="modal" href="#covcysModule">CovCys Module</a></p>
       </ul>
    </div>
        
        
        
    </div> -->
    
    

<div class="wrapper cf">

    <div id="mainsidebar">
                 <iframe id="showFrame" src="" width="100%" scrolling="no" frameborder="0"
                        onload="resizeIframe()"></iframe>
    </div>
        
    
<!--     <div id="rightsidebar"> -->
    <div class="sidebar">
      <ul class="nav nav-tabs nav-stacked" id="myNav">
        <h3>Learn more</h3>
        <p>----------</p>
        <p><a data-toggle="modal" href="#cavityModule">Cavity Module</a></p>
        <p><a data-toggle="modal" href="#pharmacophoreModule">CavPharmer Module</a></p>
        <p><a data-toggle="modal" href="#corrsiteModule">CorrSite Module</a></p>
        <p><a data-toggle="modal" href="#covcysModule">CovCys Module</a></p>
       </ul>
    </div>
        
<!--     </div> -->

</div>
    
<!--
<section>
    <div class="ui container">
        <div class="ui segment">
            <iframe id="showFrame" src="" width="100%" scrolling="no" frameborder="0" onload="resizeIframe()"></iframe>
        </div>
    </div>
</section>
-->
<footer id="contact" class="page-footer" style="background-color: #434a54">
    <div class="container">
        <div class="footer-row">
            <div class="col-lg-6">
                <h5 class="white-text">Last Updated</h5>
                <p class="grey-text text-align-left">Apr 25, 2018
                <h5 class="white-text">Jobs run</h5>
                <p class="grey-text text-align-left">
                 
     

                    <?php echo $_SESSION['counter']; ?>
                    
            </p>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <h5 class="white-text">Email</h5>
                <p class="text-align-left"><a class="grey-text"
                                              href="mailto:BioinfoF@cqb.pku.edu.cn">jfpei@pku.edu.cn</a>
                </p>
                <h5 class="white-text">telephone</h5>
                <p class="text-align-left grey-text">(86)-010-62759669</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="footer-row">

                <div class="col-lg-4 text-align- left">Address：Peking
                    University, Beijing, China
                </div>
                <div class="col-lg-2 text-align-left">Postcode：100871
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4text-align-left"> Copyright 2019©Molecular Design Laboratory
                </div>
            </div>
        </div>
    </div>
</footer> <!-- login and regester form -->
<div class="modal fade"
     id="loginFormTest" tabindex="-1" role="dialog" aria-
     labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialogmodal-lg">
        <div class="modal- content">
            <div class
                 ="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria- hidden="true"> ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Login/Registration - <a href="./index.php">CavityPlus</a></h4></div>
            <div
                    class="modal-body">
                <div class="row">
                    <div class
                         ="col-md-8" style="border-right: 1px dotted #C2C2C2 ;padding-right: 30px;">
                        <!-- Nav tabs -->
                        <ul class="nav nav- tabs">
                            <li
                                    class="active"><a href="#Login" data-toggle="tab">Login</a></li>
                            <li><a
                                        href="#Registration" data-toggle="tab">Registration</a></li>
                        </ul> <!-- Tabpanes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="Login">
                                <form role="form" class="form- horizontal">
                                    <div class="form-group"><label
                                                for="email" class="col-sm-2 control-label"> Email</label>
                                        <div class="col-sm-10"><input type="email" class="form-control" id="email1"
                                                                      placeholder="Email"/></div>
                                    </div>
                                    <div class="form-group"><label
                                                for="exampleInputPassword1" class="col-sm-2 control-label">
                                            Password</label>
                                        <div class="col-sm-10"><input type="email" class="form-control"
                                                                      id="exampleInputPassword1"
                                                                      placeholder="Email"/></div>
                                    </div>
                                    <div
                                            class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary btn- sm"> Submit
                                            </button>
                                            <a href="javascript:;">Forgot your
                                                password?</a></div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="Registration">
                                <form role="form" class="form-horizontal">
                                    <div class="form- group"><label for="email" class="col-sm-2control-label"> Name</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div
                                                        class="col-md-3"><select class="form-control">
                                                        <option>Mr.</option>
                                                        <option>Ms.</option>
                                                        <option>Mrs.</option>
                                                    </select></div>
                                                <div class="col-md-9"><input type="text" class="form-control" placeholder="Name"/></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"><label for="email" class="col-sm-2 control-label"> Email</label>
                                        <div
                                                class="col-sm-10"><input
                                                    type="email" class="form-control" id="email"
                                                    placeholder="Email"/></div>
                                    </div>
                                    <div class="form-group"><label for="mobile" class="col-sm-2 control-label"> Password</label>
                                        <div class="col-sm-10"><input type="email" class
                                            ="form-control" id="mobile" placeholder="Password"/></div>
                                    </div>
                                    <div class
                                         ="form-group"><label for="password" class="col-sm-2 control- label">
                                            Confirmation</label>
                                        <div class="col-sm-10"><input type="password" class
                                            ="form-control" id="password" placeholder="Password confirmation"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                                class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"> Save & Continue
                                            </button>
                                            <button type="button"
                                                    class="btn btn-default btn-sm"> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!--<div id="OR" class ="hidden-xs"> OR</div>-->
                    </div>
                    <div class="col- md-4">
                        <div class="row text-center sign-with">
                            <div
                                    class="col-md-12"><p>Let's say something here, like privacy
                                    clarification.</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cavity Module -->
<div class="modal fade" id="cavityModule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Cavity Module - <a href="./index.php">Cavity Plus</a></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1>introduction</h1>
                            <p>CAVITY is a structure-based protein binding site detection program. Identifying the
                                location of ligand binding sites on a protein is of fundamental importance for a range
                                of applications including molecular docking, de novo drug design, structural
                                identification and comparison of functional sites. It uses the purely geometrical method
                                to find potential ligand binding sites, then uses geometrical structure and physical
                                chemistry property information to locate ligand binding sites. CAVITY will provide a
                                maximal ligand binding affinity prediction for the binding site. The most important,
                                CAVITY can define accurate and clear binding site for drug design.</p>
                            <h1>How to use?</h1>
                            <ul style="list-style-type: none;">
                                <li><h2>Step 1</h2>Load the protein of your interest. Two ways are provided here: 1) Load from
                                    RCSB based on a valid PDB ID; 2) Upload your own protein. After this step, one
                                    protein structure will be shown in the JSmol window;
                                </li><p><br></p>
                                <li><h2>Step 2</h2>Select the chain(s) of the whole protein. Note: once the checkboxes of "Chain(s)"
                                    were selected, the selected PDB file would be generated and visualized in JSmol right now;
                                </li><p><br></p>
                                <li><h2>Step 3</h2>Select mode. CAVITY will detect the whole protein to find potential binding
                                    sites, and this is the default mode. However, a ligand file is allowed to upload by
                                    selecting "with Ligand" mode. CAVITY will detect around the given Mol2 file. It
                                    helps the program do know where the real binding site locates. In most cases, CAVITY
                                    can locate the binding site without given ligand coordinates, and users may try this
                                    mode if users are dissatisfied with the result from whole protein mode. Our webserver can automatically 
                                    extracts ligands from protein structure. Please don't load your own ligand file when you have already 
                                    selected an extracted ligand from the list because the automatic extracted ligand has a higher 
                                    priority in the computing process. Note: the absolute coordinates of the provided ligand must be located in the binding site, 
                                    otherwise, CAVITY module would fail to detect cavities;  
                                </li><p><br></p>
                                <li><h2>Step 4</h2>Advanced parameters. We have a set of default parameters to run CAVITY. But
                                    users are allowed to adjust some parameters if they want. Values for
                                    SEPARATE_MIN_DEPTH, MAX_ABSTRACT_LIMIT, SEPARATE_MAX_LIMIT and
                                    MIN_ABSTRACT_DEPTH are as follows according to the different inputs.
                                    <br>1. Standard :8/1500/6000/2 (common cavity)<br>
                                    2. Peptides :4/1500/6000/4 (shallow cavity, e.g. peptides binding site,
                                    protein-protein interface)<br>
                                    3. Large :8/2500/8000/2 (complex cavity, e.g. multi function cavity, channel,
                                    nucleic acid site)<br>
                                    4. Super :8/5000/16000/2 (super sized cavity)<br>
                                </li><p><br></p>
                                <li><h2>Step 5</h2>Run CAVITY by clicking “Submit” button. When finished, 
                                the results will be shown in the "Cavity Results" part in this page.
                                The processing time depends on the number of protein residues and complexity of protein surface. For proteins with residues less 
                                than 400, CAVITY could processing them in 3~4 minutes. More details about running time could be found in the tutorial page.
                                </li>
                                
                            </ul>
                            <p><br>You can get more information in the <a href="./tutorial.php#test1">tutorial</a> page. </p>

                        </div>
                        <!--<div id="OR" class="hidden-xs">
                            OR</div>-->
                    </div>
<!--                    <div class="col-md-4">-->
<!--                        <div class="row text-center sign-with">-->
<!--                            <div class="col-md-12">-->
<!--                                <h3>Reference</h3>-->
<!--                                <p>1.ddd</p>-->
<!--                                <p>2.ddd</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CavPharmer Module -->
<div class="modal fade" id="pharmacophoreModule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    CavPharmer Module - <a href="./index.php">Cavity Plus</a></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1>introduction</h1>
                            <p>Derived from three-dimensional structures of a specific protein binding site, a pharmacophore model
                               is the 3D arrangement of essential features that enables a molecule to exert a particular biological effect. 
                               Therefore, it can provide useful information for analyzing protein-ligand interactions and help guide computational drug design. 
                               Cavpharmer server is a freely accessed webserver based on the pharmacophore modeling software pocket v.4. 
                               It will output six feature types, namely hydrophobic center, hydrogen bond acceptor, hydrogen bond donor, 
                               positive-charged center, negative-charged center and exclude volume, from a target protein.</p>
                            <h1>How to use?</h1>
                            <ul style="list-style-type: none;">
                                <li><h2>Step 1</h2>To use this module, CAVITY module must be run first. When cavity module finished
                                    successfully, a list of cavity results will be shown after the "Select a cavity" label. Please
                                    select one result as input to generate pharmacophores;
                                </li><p><br></p>
                                <li><h2>Step 2</h2>Select mode. CavPharmer Module can be used for either receptor-based or ligand-based
                                    pharmacophore generation. "With Ligand" should be selected and a ligand need to be given if
                                    ligand-based pharmacophore generation is expected. The ligand can be selected in the "Ligand(s)" list 
                                    or uploaded with MOL2 format. Note: the absolute coordinates of 
                                    the provided ligand must be located in the binding site;
                                </li><p><br></p>
                                <li><h2>Step 3</h2>Run program by clicking "Submit" button. When finished, the results will be shown in JSmol window.
                                Some information is provided in "CavPharmer Results" part. The processing time 
                                depends on the size of input cavity. Usually it will take a few minutes to do it but more time may be needed  
                                when the input cavity is very large (for example, more than 600 atoms). Please be patient to wait the program finishes.
                                </li>
                                
                            </ul>
                            <p><br>You can get more information in the <a href="tutorial.php#test2">tutorial</a> page. </p>

                        </div>
                        <!--<div id="OR" class="hidden-xs">
                            OR</div>-->
                    </div>
<!--                    <div class="col-md-4">-->
<!--                        <div class="row text-center sign-with">-->
<!--                            <div class="col-md-12">-->
<!--                                <h3>Reference</h3>-->
<!--                                <p>1.ddd</p>-->
<!--                                <p>2.ddd</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CorrSite Module -->
<div class="modal fade" id="corrsiteModule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    CorrSite Module - <a href="./index.php">Cavity Plus</a></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1>introduction</h1>
                            <p>Allostery is the phenomenon in which a ligand binding at one site affects other sites
                                    in the same macromolecule. Allostery has important roles in many biological
                                    processes, such as enzyme catalysis, signal transduction, and gene regulation.
                                    Allosteric drugs have several advantages compared with traditional orthosteric
                                    drugs, including fewer side effects and easier up- or down-regulation of target
                                    activity. Theoretically, all nonfibrous proteins are potentially allosteric. Given
                                    an nonfibrous protein structure, it is important to identify the location of
                                    allosteric sites before doing structure-based allosteric drug design on it.
                                    CorrSite Server is a freely accessed web-server designed to identify potential protein allosteric sites.</p>
                            <h1>How to use?</h1>
                            <ul style="list-style-type: none;">
                                <li><h2>Step 1</h2>Set the orthosteric sites:
                                    1. Cavity pockets: results of CAVITY module. Select the result that are orthosteric sites.<br>
                                    2. Custom pockets: Upload one PDB file of orthosteric sites. <br>
                                    3. Custom residues: This server also support the custom .txt file, like the following: (residueID: ChainID)<br>
                                    46:A<br>
                                    47:A<br>
                                    49:A<br>

                                </li><p><br></p>
                                <li><h2>Step 2</h2>Run program by clicking "Submit" button. The results will be shown in "CorrSite Results" part.</li>
                            </ul>
                            <p><br>You can get more information in the <a href="./tutorial.php#test3">tutorial</a> page. </p>

                        </div>
                        <!--<div id="OR" class="hidden-xs">
                            OR</div>-->
                    </div>
<!--                    <div class="col-md-4">-->
<!--                        <div class="row text-center sign-with">-->
<!--                            <div class="col-md-12">-->
<!--                                <h3>Reference</h3>-->
<!--                                <p>1.ddd</p>-->
<!--                                <p>2.ddd</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CovCys Module -->
<div class="modal fade" id="covcysModule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    CovCys Module - <a href="./index.php">Cavity Plus</a></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" >
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1>Introduction</h1>
                            <p>The covCys is developed based on a comprehensive statistical analysis on covalent modified
                                cysteine residues in protein structures. Compared to unmodified cysteine residues in the same protein structure,
                                the covalently modified cysteine residues showed lower pKa values and higher solvent exposure.
                                Such cysteine residues are usually located within or near one of many pockets detected by a pocket-detection program.</p>
                            <h1>How to use?</h1>
                            <ul style="list-style-type: none;">
                                <li><h2>Step 1</h2>The input of this module are all the cavity results that CAVITY program detected. Run CAVITY first, then click
                                    "Run CovCys" button, the results will be shown in "CovCys Results" part.
                                </li>
                            </ul>
                            <p><br>You can get more information in the <a href="./tutorial.php#test4">tutorial</a> page. </p>

                        </div>
                        <!--<div id="OR" class="hidden-xs">
                            OR</div>-->
                    </div>
<!--                    <div class="col-md-4">-->
<!--                        <div class="row text-center sign-with">-->
<!--                            <div class="col-md-12">-->
<!--                                <h3>Reference</h3>-->
<!--                                <p>1.ddd</p>-->
<!--                                <p>2.ddd</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Portfolio Modals -->
<!-- Use the modals below to showcase details about your portfolio projects! -->

<!-- Portfolio Modal 1 -->
<div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                               <h2>Cavity</h2>
                            <p class="item-intro text-muted">Mapping the druggable protein binding site</p>
                            
                            <div class="content">
                                
                                <p>Identifying reliable binding sites based on three dimensional structures of proteins and other macromolecules is a key step in drug discovery.  A good definition of known binding site and the detection of a novel site can provide valuable information for drug design efforts. CAVITY is developed for the detection and analysis of ligand-binding site(s) . It has the capability of detecting  potential binding site  as well as estimating  both the ligandabilities and druggabilites of the detected binding sites.</p>
                                <p>CAVITY was originally used in the de novo drug design tool LigBuilder 2.0 to accurately reflect the key interactions within a binding site as well as to confine the ligand growth within a reasonable region; it was later developed into a stand-alone program for binding site detection and analysis. The CAVITY approach generates clear and accurate information about the shapes and boundaries of the ligand binding sites, which provide helpful information for drug discovery studies: 1) For cases where a protein-ligand complex of the target protein is available, CAVITY can be used to detect the binding site regions which are not covered by the known ligand(s) and provide clues for the improvement of ligand-binding affinity. In addition, the predicted ligandability and druggability of the binding site would tell the researchers whether further improvement of the known ligand is promising. 2) For cases where ligands are known, but the structural information of ligand-target interactions is not available, CAVITY can be used to detect the binding site and the binding mode of the known ligands could be predicted by using molecular docking technique. 3) For cases with no reported ligand, CAVITY can not only be used to detect potential binding sites, but also to provide qualitative estimations of ligandability and druggability for potential binding sites on the target protein, which is very important for making an early stage decision about whether the protein  is a promising target for a drug discovery project. CAVITY has been used in many different projects to help generate such information and clues. We used the external NRDLD data set and Cheng’s data set to test Cavity, showing a satisfactory performance of 0.82 and 0.89 accuracy, respectively.</p>


                                <img class="img-responsive img-centered" src="img/cavity_learn_more.jpg" alt="" width="50%">
                                <p style="text-align:center"><b>Schematic diagram of cavity detection in CAVITY.</b> a) Protein (black-colored) in grid box (green-colored). b) Using the eraser ball to remove grid points outside protein. c) “Vacant” grid points after erasing. Four cavities were shown in different colors. d) Shrink each cavity until the depth reach the minimal depth. e) Recover cavities to obtain the final result.</p>



                            </div>
                            <div class="reference">
                                <p><strong>Reference:</strong></p>
                            </div>
                            <p>

                                Yaxia Yuan, Jianfeng Pei, Luhua Lai. Binding Site Detection and Druggability Prediction of Protein Targets for Structure-Based Drug Design. Current Pharmaceutical Design, 2013,19 (12), 2326-2333(8). <a href="https://www.ncbi.nlm.nih.gov/pubmed/23082974">Link.</a></p>
                            <p>
                                Yaxia Yuan, Jianfeng Pei, Luhua Lai. LigBuilder 2: A Practical de Novo Drug Design Approach. J. Chem. Inf. Model., 2011, 51 (5), 1083-1091. <a href="https://www.ncbi.nlm.nih.gov/pubmed/21513346">Link.</a></p>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-2">
                            <a href="./computation.php"><button type="button" class="btn btn-primary"><i class="fa fa-times"></i>Start Computing</button></a>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>Back to homepage</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 2 -->
<div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>CavPharmer</h2>
                            <p class="item-intro text-muted">Receptor-based Pharmacophore Modeling.</p>
                            <img class="img-responsive img-centered" src="img/pocket.png" alt="">
                            <div class="content">
                                <p>Pharmacophores derived from three-dimensional structures of specific protein binding sites can provide useful information for analyzing protein-ligand interactions, which therefore will help guide computational drug design.  Pharmacophore features and their spatial arrangements are usually used to describe a pharmacophore model.  CavPharmer uses a receptor-based pharmacophore modeling program Pocket2 to automatically extract pharmacophore features within cavities. CavPharmer output 7 feature types as hydrophobic center, hydrogen bond donor, hydrogen bond acceptor, positive-charged center, negative-charged center, aromatic center and exclude volume, to make a pharmacophore model from a protein structure integral. Key features in the pharmacophore model are automatically reduced to a reasonable number. We used data from DUD database to test the efficiency of CavPharmer and a ligand-based pharmacophore modeling software LigandScout V2.02. Results show that for receptor-based pharmacophore modeling, CavPharmer outperforms LigandScout. (average AUC value 0.69 versus 0.63 in 38 cases) Overall, CavPharmer is an accurate pharmacophore modeling software and can be applied widely into different drug design cases.</p>
                                <p>CavPharmer can also identify hot spots in protein-protein interface using only an apo protein structure. Given similarities and differences between the essence of pharmacophore and hot spots for guiding design of chemical compounds, not only energetic but also spatial properties of protein-protein interface are used in CavPharmer for dealing with protein-protein interface.</p>
                                <p>CavPharmer has been applied to many studies and well reproduced previously published pharmacophore models in these cases. One notable feature of CavPharmer is that it can tolerate minor conformational changes on the protein side upon binding of different ligands to give a consistent pharmacophore model. For different proteins accommodating the same ligand, CavPharmer gives similar pharmacophore models, which opens the possibility to classify proteins with their binding features. The Pharmacophore models used in Pharmmapper 2017 server <a href="http://lilab.ecust.edu.cn/pharmmapper">(http://lilab.ecust.edu.cn/pharmmapper)</a> were generated using CavPharmer method.</p>
                            </div>
                            <div class="reference">
                                <p><strong>Reference:</strong></p>
                            </div>
                            <p>

                                J Chen, LH Lai, Pocket v.2: Further Developments on Receptor-Based Pharmacophore Modeling, J. Chem. Inf. Model., 2006,46(6),2684-2691.<a href="https://www.ncbi.nlm.nih.gov/pubmed/17125208">Link.</a></p>
                            <div class="row">
                                <div class="col-lg-4 col-lg-offset-2">
                                    <a href="./computation.php"><button type="button" class="btn btn-primary"><i class="fa fa-times"></i>Start Computing</button></a>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>Back to homepage</button>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 3 -->
<div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                          <h2>Corrsite</h2>
                            <p class="item-intro text-muted">Potential allosteric ligand binding site prediction</p>
                            <img class="img-responsive img-centered" src="img/corrsite.png" alt="">
                            <div class="content">
                                <p>Allostery is the phenomenon in which a ligand binding at one site affects other sites in the same macromolecule. Allostery has important roles in many biological processes, such as enzyme catalysis, signal transduction, and gene regulation. Allosteric drugs have several advantages compared with traditional orthosteric drugs, including fewer side effects and easier up- or down-regulation of target activity. Theoretically, all nonfibrous proteins are potentially allosteric. Given an nonfibrous protein structure, it is important to identify the location of allosteric sites before doing structure-based allosteric drug design on it.</p>
                                <p>CorrSite identifies potential allosteric ligand binding sites based on motion correlation analysis between allosteric and orthosteric cavities. First, the program imports the coordinates of protein atoms from a PDB file and its orthosteric site information. Then, the program detects the potential protein binding sites by using CAVITY. The calculated cavities with greater than 75% overlapping residues with the orthosteric site are excluded. After that, the program calculates correlations between these potential ligand-binding sites and corresponding orthosteric sites using a Gaussian network model (GNM). If the normalized correlation of one cavity is more than 0.5, this cavity is identified as a potential allosteric site. Among the 24 known allosteric sites, 23 sites were correctly predicted by the Corrsite program. </p>
                            </div>
                            <div class="reference">
                                <p><strong>Reference:</strong></p>
                            </div>
                            <p>
                                Xiaomin Ma, Hu Meng, Luhua Lai. Motions of Allosteric and Orthosteric Ligand-Binding Sites in Proteins are Highly Correlated. J. Chem. Inf. Model., 2016, 56 (9), 1725-1733. <a href="https://www.ncbi.nlm.nih.gov/pubmed/27580047">Link.</a></p>
                            <p>Yaxia Yuan, Jianfeng Pei, Luhua Lai. Binding site detection and druggability prediction of protein targets for structure-based drug design. Current pharmaceutical design 19.12 (2013): 2326-2333. <a href="https://www.ncbi.nlm.nih.gov/pubmed/23082974">Link.</a></p>
                            <div class="row">
                                <div class="col-lg-4 col-lg-offset-2">
                                    <a href="./computation.php">
                                        <button type="button" class="btn btn-primary"><i class="fa fa-times"></i>Start
                                            Comuting
                                        </button>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                                class="fa fa-times"></i>Back to homepage
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Modal 4 -->
<div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <!-- Project Details Go Here -->
                            <h2>CovCys</h2>
                            <p class="item-intro text-muted">Detecting druggable cysteine residues for covalent ligand design</p>
                            <img class="img-responsive img-centered" src="img/cyspred.png" alt="">
                            <div class="content">
                                <p>CovCys is developed based on a comprehensive statistical analysis on covalent modified cysteine residues in protein structures. Compared to unmodified cysteine residues in the same protein structure, the covalently modified cysteine residues showed lower pKa values and higher solvent exposure. Such cysteine residues are usually located within or near one of many pockets detected by a cavity-detection program.</p>
                                <p>The current application of computational procedure for targetable cysteine prediction only requires the protein three-dimensional structure coordinates. A number of descriptors will be calculated based on the structure, including surface pockets detected by using CAVITY, pKa by using PROPKA, SASA by using Pops as well as adjacent amino acid compositions calculated based on ProODY package. The generated descriptors will be used as the input for a pre-trained SVM model to predict whether a cysteine residues are suitable for druglike covalent ligand design. The external validation data set (positive/negative: 1377/5185) from Cysteinome
database was tested by CovCys with prediction accuracy of 0.73.</p>
                                <p>Currently, if a cysteine is not within a pocket, it will not be used to make prediction. Such cysteine maybe an active cysteine, but it is hard to design a proper ligand without a binding cavity. Meanwhile, if the pKa calculation failed, it is also not considered. Such cysteine could be in a form of di-sulfur bond or inside the protein.</p>
                                <p>To use CovCys, please upload your protein structure information in the computing page. The output results contains all cysteine residues within the protein and their probability to be a druggable covalent reside. The pKa, percentage of exposure and the average pKd value of the associated pocket are also reported.</p>
                                </div>
                                <div class="reference">
                                    <p><strong>Reference:</strong></p>
                                </div>
                                <p> Zhang W, Pei J, Lai L. Statistical Analysis and Prediction of Covalent Ligand Targeted Cysteine Residues. J Chem Inf Model. 2017,57, 1453-1460. <a href="https://www.ncbi.nlm.nih.gov/pubmed/28510428">Link.</a></p>
                                <p>Yuan Y., Pei J., Lai L. Binding Site Detection and Druggability Prediction of Protein Targets for Structure-Based Drug Design. Current Pharmaceutical Design, 2013,19, 2326-2333. <a href="https://www.ncbi.nlm.nih.gov/pubmed/23082974">Link.</a></p>
                                <p>Bas, D. C.; Rogers, D. M.; Jensen, J. H. Very Fast Prediction and Rationalization of pKa Values for Protein–Ligand Complexes Proteins: Struct., Funct., Genet. 2008, 73, 765–783. <a href="https://www.ncbi.nlm.nih.gov/pubmed/18498103">Link.</a></p>
                                <p>Marino, S. M. Protein Flexibility and Cysteine Reactivity: Influence of Mobility on the H-Bond Network and Effects on Pka Prediction Protein J. 2014, 33, 323– 336. <a href="https://www.ncbi.nlm.nih.gov/pubmed/24809821">Link.</a></p>
                                <p>Cavallo, L.; Kleinjung, J.; Fraternali, F. Pops: A Fast Algorithm for Solvent Accessible Surface Areas at Atomic and Residue Level Nucleic Acids Res. 2003, 31, 3364–3366. <a href="https://www.ncbi.nlm.nih.gov/pubmed/12824328">Link.</a></p>
                                <p>Bakan, A.; Meireles, L. M.; Bahar, I. ProDy: Protein Dynamics Inferred from Theory and Experiments Bioinformatics 2011, 27, 1575–1577. <a href="https://www.ncbi.nlm.nih.gov/pubmed/21471012">Link.</a></p>

                            <div class="row">
                                <div class="col-lg-4 col-lg-offset-2">
                                    <a href="./computation.php">
                                        <button type="button" class="btn btn-primary"><i class="fa fa-times"></i>Start
                                            Comuting
                                        </button>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                                class="fa fa-times"></i>Back to homepage
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Theme JavaScript -->
<script src="js/agency.min.js"></script>

<!-- side help -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/side-help.js"></script>
</body>
</html>
