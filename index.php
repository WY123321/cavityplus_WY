<!DOCTYPE html>
<html lang="en">


<?php
session_start();
$counter = intval(file_get_contents("resource/counter/counter.log"));
$_SESSION['counter']=$counter;
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/pku_favicon.ico" mce_href="/img/pku_favicon.ico" type="image/x-icon">
    <title>CavityPlus</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic" rel="stylesheet" type="text/css">
    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" class="index">

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">
                <font size='6'>CavityPlus</font>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="page-scroll" href="#about">about</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./computation.php">Computing</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="#toolbox">Toolbox</a>
                    <div class="dropdown-content">
                        <p><a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">Cavity</a></p>
                        <p><a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">CavPharmer</a></p>
                        <p><a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">Corrsite</a></p>
                        <p><a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">CovCys</a></p>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./tutorial.php">Tutorial</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="#publications">Reference</a>
                </li>
                <li class="dropdown">
                    <!--<a class="btn" data-toggle="modal" data-target="#loginFormTest">Log in</a>-->
                    <a class="page-scroll" href="#contact">Contact Us</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Header -->
<header>
    <div class="container">
        <div class="intro-text">
            <!--<div class="intro-lead-in">
                <h5>
                    <font size='4'>A web server for protein cavity detection with phamacophore modeling, allosteric effect and covalent ligand binding ability prediction.</font>
                </h5>
            </div>-->
            <div class="intro-heading">CavityPlus:</div>
            <div class="intro-subheading">Protein cavity detection and beyond</div>
            <a href="./computation.php" class="page-scroll btn btn-xl">Start Computing</a>
            <a href="./tutorial.php" class="btn btn-xl">Tutorial</a>
        </div>
    </div>
</header>

<!-- Services Section -->
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="section-heading">about</h2>
            </div>
            <div class="col-md-8">
		<p class="p-about">
		<b>CavityPlus</b> is a web server for precise and robust protein cavity detection and functional analysis. With protein 3D structural information as input, <b>CavityPlus</b> applies <b>Cavity</b> to detect the potential binding sites on the surface of a given protein structure and rank them with ligandability and druggability scores. Based on the detected protein cavity information, further functions of a protein cavity are then analyzed by using three submodules, namely <b>CavPharmer</b>, <b>CorrSite</b> and <b>CovCys</b>. <b>CavPharmer</b> uses a receptor-based pharmacophore modeling program Pocket to automatically extract pharmacophore features within cavities. <b>CorrSite</b> identifies potential allosteric ligand binding sites based on motion correlation analysis between allosteric and orthosteric cavities. <b>CovCys</b> automatically detects druggable cysteine residues for covalent ligand design, which is especially useful for identifying novel binding sites for covalent allosteric ligand design. Overall, <b>CavityPlus</b> provides an integrated platform for analyzing comprehensive properties of protein binding cavities, which is useful in many aspects for drug design and discovery such as target selection and identification, virtual screening and <i>de novo</i> drug design, allosteric and covalent-binding drug design.
		</p>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Grid Section -->
<section id="toolbox" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">toolbox</h2>
                <h3>Comprehensive analysis of protein binding cavities.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" align="center">
                <div class="hover11">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <figure>
                            <img src="img/cavity.png" class="img-responsive" alt="" width=80%>
                            <button class="btn-custom custom-button">Learn More</button>
                        </figure>
                    </a>
                </div>
                <div class="portfolio-caption">
                    <h4>Cavity</h4>
                    <p class="text-muted pwidth">Mapping the druggable protein binding site<br></p>
                </div>

            </div>
            <div class="col-lg-6" align="center">
                <div class="hover11">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <figure>
                            <img src="img/pocket.png" class="img-responsive" alt="" width=80%>
                            <button class="btn-custom custom-button">Learn More</button>
                        </figure>
                    </a>
                </div>
                <div class="portfolio-caption">
                    <h4>CavPharmer</h4>
                    <p class="text-muted pwidth">Receptor-based Pharmacophore Modeling<br></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" align="center">
                <div class="hover11">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <figure>
                            <img src="img/corrsite.png" class="img-responsive" alt="" width=80%>
                            <button class="btn-custom custom-button">Learn More</button>
                        </figure>
                    </a>
                </div>
                <div class="portfolio-caption">
                    <h4>Corrsite</h4>
                    <p class="text-muted pwidth">Potential allosteric ligand binding site prediction<br></p>
                </div>
            </div>
            <div class="col-lg-6" align="center">
                <div class="hover11">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <figure>
                            <img src="img/cyspred.png" class="img-responsive" alt="" width=80%>
                            <button class="btn-custom custom-button">Learn More</button>
                        </figure>
                    </a>
                </div>
                <div class="portfolio-caption">
                    <h4>CovCys</h4>
                    <p class="text-muted pwidth">Detecting druggable cysteine residues for covalent ligand design<br></p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Publication Section -->
<section id="publications" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">reference</h2>
                <p class="p-about">

                <p style="text-align: left">1. Xu,Y., Wang,S., Hu,Q., Gao,S., Ma,X., Zhang,W., Shen,Y., Chen,F., Lai,L. and Pei,J. (2018) CavityPlus: a web server for protein cavity detection with pharmacophore modelling, allosteric site identification and covalent ligand binding ability prediction. Nucleic Acids Research, 46, W374-W379. <a href="https://academic.oup.com/nar/advance-article/doi/10.1093/nar/gky380/4994680">Link.</a></p>
                    <p style="text-align: left">2. Yuan,Y., Pei,J., and Lai,L. (2013) Binding Site Detection and Druggability Prediction of Protein Targets for Structure-Based Drug Design. Curr Pharm Des., 19, 2326-2333. <a href="https://www.ncbi.nlm.nih.gov/pubmed/23082974">Link.</a></p>
                    <p style="text-align: left">3. Yuan,Y., Pei,J., and Lai,L. (2011) LigBuilder 2: A Practical de Novo Drug Design Approach. J. Chem. Inf. Model., 51, 1083-1091.<a href="https://www.ncbi.nlm.nih.gov/pubmed/21513346">Link.</a></p>
                    <p style="text-align: left">4. Chen,J., and Lai,L. (2006) Pocket v.2: Further Developments on Receptor-Based Pharmacophore Modeling. J. Chem. Inf. Model., 46, 2684-2691.<a href="https://www.ncbi.nlm.nih.gov/pubmed/17125208">Link.</a></p>
                    <p style="text-align: left">5. Chen, J., Ma, X., Yuan, Y., Pei, J., and Lai, L. (2014). Protein-protein interface analysis and hot spots identification for chemical ligand design. Curr Pharm Des., 20, 1192-1200. <a href="https://www.ncbi.nlm.nih.gov/pubmed/23713772">Link.</a></p>
                    <p style="text-align: left">6. Ma, X., Meng, H., and Lai, L. (2016). Motions of allosteric and orthosteric ligand-binding sites in proteins are highly correlated. J. Chem. Inf. Model., 56, 1725-1733.<a href="https://www.ncbi.nlm.nih.gov/pubmed/27580047">Link.</a></p>
                    <p style="text-align: left">7. Zhang, W., Pei, J., and Lai, L. (2017). Statistical Analysis and Prediction of Covalent Ligand Targeted Cysteine Residues. J. Chem. Inf. Model., 51, 1453-1460.<a href="https://www.ncbi.nlm.nih.gov/pubmed/28510428">Link.</a></p>
</div>
        </div>
    </div>
</section>
    

    

<!-- Contact Section -->
<section id="contact" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Contact us</h2>
                <h3 class="section-subheading text-muted bottom-margin-sm"></h3>
                <a target="_blank" href="mailto:jfpei@pku.edu.cn" class="btn btn-xl">Contact </a>
            
            </div>
        </div>


    </div>
</section>
    
        <!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Related resources:</h2>
                <h3 class="section-subheading text-muted bottom-margin-sm"></h3>
                <a target="_blank" href="http://repharma.pku.edu.cn/ligbuilder" class="btn btn-xl">LigBuilder V2.0</a>
            
            </div>
        </div>


    </div>
</section>


<footer id="contact" class="page-footer" style="background-color: #434a54">
    <div class="container">
        <div class="footer-row">
            <div class="col-lg-6">
                <h5 class="white-text">Last Updated</h5>
                <p class="grey-text text-align-left">Apr 25, 2018</p>
		<h5 class="white-text">Jobs run</h5>
		<div class="grey-text text-align-left"><!--<a href='https://www.counter12.com'><img src='https://www.counter12.com/img-ZaYCZDA8Bcb7yC52-3.gif' border='0' alt='web counter free'></a><script type='text/javascript' src='https://www.counter12.com/ad.js?id=ZaYCZDA8Bcb7yC52'></script>-->

            <?php echo $_SESSION['counter']; ?>
                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <h5 class="white-text">Email</h5>
                <p class="text-align-left"><a class="grey-text" href="mailto:BioinfoF@cqb.pku.edu.cn" >jfpei@pku.edu.cn</a></p>
                <h5 class="white-text">telephone</h5>
                <p class="text-align-left grey-text">(86)-010-62759669</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="footer-row">
                <div class="col-lg-4 text-align-left">Address：Peking University, Beijing, China</div>
                <div class="col-lg-2 text-align-left">Postcode：100871</div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4 text-align-left">
                    Copyright 2019©Molecular Design Laboratory
                </div>
            </div>
        </div>
    </div>
</footer>



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
                            <!-- Project Details Go Here -->
                            <h2>Cavity</h2>
                            <p class="item-intro text-muted">Mapping the druggable protein binding site</p>
                            
                            <div class="content">
                                
                                <p>Identifying reliable binding sites based on three dimensional structures of proteins and other macromolecules is a key step in drug discovery.  A good definition of known binding site and the detection of a novel site can provide valuable information for drug design efforts. CAVITY is developed for the detection and analysis of ligand-binding site(s) . It has the capability of detecting  potential binding site  as well as estimating  both the ligandabilities and druggabilites of the detected binding sites.</p>
                                <p>CAVITY was originally used in the de novo drug design tool LigBuilder 2.0 to accurately reflect the key interactions within a binding site as well as to confine the ligand growth within a reasonable region; it was later developed into a stand-alone program for binding site detection and analysis. The CAVITY approach generates clear and accurate information about the shapes and boundaries of the ligand binding sites, which provide helpful information for drug discovery studies: 1) For cases where a protein-ligand complex of the target protein is available, CAVITY can be used to detect the binding site regions which are not covered by the known ligand(s) and provide clues for the improvement of ligand-binding affinity. In addition, the predicted ligandability and druggability of the binding site would tell the researchers whether further improvement of the known ligand is promising. 2) For cases where ligands are known, but the structural information of ligand-target interactions is not available, CAVITY can be used to detect the binding site and the binding mode of the known ligands could be predicted by using molecular docking technique. 3) For cases with no reported ligand, CAVITY can not only be used to detect potential binding sites, but also to provide qualitative estimations of ligandability and druggability for potential binding sites on the target protein, which is very important for making an early stage decision on whether the protein is a promising target for a drug discovery project. CAVITY has been used in many different projects to help generate such information and clues. We used the external NRDLD data set and Cheng’s data set to test Cavity, showing a satisfactory performance of 0.82 and 0.89 accuracy, respectively.</p>


                                <img class="img-responsive img-centered" src="img/cavity_learn_more.jpg" alt="" width="50%">
                                <p style="text-align:center"><b>Schematic diagram of cavity detection in CAVITY.</b> a) Protein (black-colored) in grid box (green-colored). b) Using the eraser ball to remove grid points outside protein. c) "Vacant" grid points after erasing. Four cavities were shown in different colors. d) Shrink each cavity until the depth reach the minimal depth. e) Recover cavities to obtain the final result.</p>



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
                                <p>CorrSite identifies potential allosteric ligand binding sites based on motion correlation analysis between allosteric and orthosteric cavities. First, the program imports the coordinates of protein atoms from a PDB file and its orthosteric site information. Then, the program detects the potential protein binding sites by using CAVITY. The calculated cavities with greater than 75% overlapping residues with the orthosteric site are excluded. After that, the program calculates correlations between these potential ligand-binding sites and corresponding orthosteric sites using a Gaussian network model(GNM). If the normalized correlation of one cavity is more than 0.5, this cavity is identified as a potential allosteric site. Among the 24 known allosteric sites, 23 sites were correctly predicted by the Corrsite program. </p>
                            </div>
                            <div class="reference">
                                <p><strong>Reference:</strong></p>
                            </div>
                            <p>
                                Xiaomin Ma, Hu Meng, Luhua Lai. Motions of Allosteric and Orthosteric Ligand-Binding Sites in Proteins are Highly Correlated. J. Chem. Inf. Model., 2016, 56 (9), 1725-1733. <a href="https://www.ncbi.nlm.nih.gov/pubmed/27580047">Link.</a></p>
                            <p>Yaxia Yuan, Jianfeng Pei, Luhua Lai. Binding site detection and druggability prediction of protein targets for structure-based drug design. Current pharmaceutical design 19.12 (2013): 2326-2333. <a href="https://www.ncbi.nlm.nih.gov/pubmed/23082974">Link.</a></p>
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
<!-- jQuery -->
<!--<script src="vendor/jquery/jquery.min.js"></script>-->

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="js/agency.min.js"></script>

<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.1.4/semantic.min.css" />-->


</body>

</html>
