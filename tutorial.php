<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" href="/img/pku_favicon.ico" mce_href="/img/pku_favicon.ico" type="image/x-icon">
    <title>CavityPlus</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic" rel="stylesheet"
          type="text/css">
    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                    <a class="page-scroll" href="./index.php#toolbox">TOOLBOX</a>

                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="./tutorial.php">Tutorial</a>
                </li>
                <li class="dropdown">
                    <a class="page-scroll" href="#publications">reference</a>
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

<img src="img/computationHeader.jpg" width="100%"/>


<!-- Services Section -->
<section class="tutorial-section-small-bottom" id="tutorial">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="section-heading">tutorial</h2>
                <ul>
                        <span style="font-size:24px;"> 
                        
                        <li>
                            <a class="page-scroll" href="#test1" style="font-size: large;">Cavity</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#test2" style="font-size: large;">CavPharmer</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#test3" style="font-size: large;">CorrSite</a>
                        </li>

                        <li>
                            <a class="page-scroll" href="#test4" style="font-size: large;">CovCys</a>
                        </li>
                            </span>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="catalogue">
                    <a id="test0"></a>
                    <h2 class="section-heading">Overview of CavityPlus</h2>

                    <span style="font-size:20px;">
            <b>CavityPlus</b> is a web server for precise and robust protein cavity detection and functional analysis. With protein 3D structural information as input, </p>
                        <li><a href="#test1"><b>Cavity</b></a> is used to detect the potential binding sites on the surface of a given protein structure and rank them with ligandability and druggability scores. <br>   </li>
Based on the detected protein cavity information, further functions of a protein cavity are then analyzed by using three submodules, namely <b>CavPharmer</b>, <b>CorrSite</b> and <b>CovCys</b>. <br>
<li><a href="#test2"><b>CavPharmer</b></a> uses a receptor-based pharmacophore modeling program Pocket to automatically extract pharmacophore features within cavities. <br></li>
<li><a href="#test3"><b>CorrSite</b></a> identifies potential allosteric ligand binding sites based on motion correlation analysis between allosteric and orthosteric cavities.<br> </li>
<li><a href="#test4"><b>CovCys</b></a> automatically detects druggable cysteine residues for covalent ligand design, which is especially useful for identifying novel binding sites for covalent allosteric ligand design.<br></li>
The overall flowchart of how to use <b>CavityPlus </b> is as follows:
                        </span>


                    <div style="text-align:center;"><img src="imgs/t2.png" width="80%"></div>
                    <p class="p-tutorial"></p>
                    <section class="tutorial-section" id="test1">
                        <h3 class="h3-tutorial">Cavity</h3>
                        <p class="p-tutorial">
                        <h3 style="color:blue;">Step 1</h3>
                        Load a protein of your interest. Two ways are provided here:<br>
                        1) Load from RCSB PDB based on a valid PDB ID; <br>
                        2) Upload your own protein of interest.<br>
                        After this step, one protein structure will be shown in the JSmol window.
                        <li>If the protein was successfully loaded, there will be a pop-up window and the structure will
                            be shown in the JSmol window.
                        </li>
                        <li>If you have a previous finished job and you are going to submit a new structure in the same
                            webpage, the results of previous job will be deleted. So make sure you have downloaded the
                            results before submitting a new job.
                        </li>
                        <br>
                        <img src="imgs/1.png" width="85%"><br>
                        Figure 1. Visualization of Cavity operation interface. Red rectangles show the input protein and
                        its chains. Red ellipse with the "sample" can be clicked to download. <br>

                        <h3 style="color:blue;">Step 2</h3>

                        <p>Select the chain(s) from the whole protein, and it will be shown in JSmol right now.<br>
                            <b>Note: CAVITY will automatically remove water molecules, ion atoms and ligand atoms from
                                structure.</b> <br>
                            <img src="imgs/2.png" width="85%"><br>
                            Figure 2. Visualization of Cavity submission. Red rectangles show the current selected
                            chain, then submit Cavity to detect pockets with a roughly estimated computational time.


                        <h3 style="color:blue;">Step 3 </h3>
                        <li>Select mode. CAVITY will detect the whole protein to find potential binding sites, and this
                            is
                            the default mode. And it is available to upload a ligand file by selecting "with Ligand"
                            mode.
                            CAVITY will detect around the given Mol2 file. It helps the program do know where the real
                            binding site locates. In most cases, CAVITY could locate the binding site without given
                            ligand
                            coordinates, and you are allowed to try this mode if you are dissatisfied with the results
                            from whole protein mode.
                        </li>
                        <li>It should be noted that the given ligand in "With Ligand" mode must be located in the
                            binding site. Otherwise, CAVITY module would fail to detect pockets. An error message would
                            pop out if the ligand were not correct. Our webserver can automatically extracts ligands
                            from protein structure (shown in Figure 3). Please don’t load your own ligand file when you
                            have already selected an extracted ligand from the list because the automatic extracted
                            ligand has a higher priority in the computing process.
                        </li>
                        <img src="imgs/3.png" width="40%"><br>
                        Figure 3. Visualization of "ligand mode" and "Advanced parameters" with red rectangles.

                        <h3 style="color:blue;">Step 4 </h3>
                        Advanced parameters (shown in Figure 3). We have a set of default parameters to run
                        CAVITY. And you are allowed to adjust some parameters of your interest.
                        Explanations for the parameters:
                        <li>SEPARATE_MIN_DEPTH (SMD), MAX_ABSTRACT_LIMIT_V(MALV), SEPARATE_MAX_LIMIT_V(SMLV) and
                            MIN_ABSTRACT_DEPTH(MAD) are used for cavity detection process, which determine the depth and
                            volume of cavity. The bigger values are related to larger cavities. Actually, we have
                            provided four parameter sets for different inputs in our web.
                        </li>
                        <li>The first parameter set (8/1500/6000/2 for SMD/MALV/SMLV/MAD) is used for common cavity,
                            which is also the default parameters of CAVITY.
                        </li>
                        <li>The second parameter set (4/1500/6000/4 for SMD/MALV/SMLV/MAD) is used for shallow cavity,
                            such as peptides binding site and protein-protein interface.
                        </li>
                        <li>The third parameter set (8/2500/8000/2 for SMD/MALV/SMLV/MAD) is used for complex cavity,
                            such as multi function cavity, channel and nucleic acid site.
                        </li>
                        <li>The final parameter set (8/5000/16000/2 for SMD/MALV/SMLV/MAD) is used for super-sized
                            cavity. These set of parameters are recommended to be used for proper inputs.
                        </li>
                        <li>RULER_1 and OUTPUT_RANK are used as output filter. RULER_1 limits the minimum volume of
                            cavity and OUTPUT_RANK limits the minimum CavityScore. CAVITY will only output detected
                            binding sites whose CavityScore is greater than OUTPUT_RANK. User may increase this value to
                            prevent CAVITY outputting useless results.
                        </li>


                        <h3 style="color:blue;">Step 5</h3>
                        <p>Run CAVITY by clicking "Submit" button.
                        <li>Before running CAVITY, our web server will check the Chain checkbox to ensure the selected
                            protein and submitted protein are the same one.
                        </li>
                        <li>It will take some time to detect potential cavities of a given protein. The processing time
                            of CAVITY increases significantly with the increasing number of residues and complexity of
                            protein. We have done a test by running CAVITY with a test dataset that contains 100
                            proteins selected from PDBBind database. The protein sequence length was between 87 and
                            1760. The test result showed that for most of proteins with residues less than 400, CAVITY
                            could processing them in 3 minutes. When the number of residues increases, the processing
                            time increases significantly. The biggest protein (with 1760 residues) in our test dataset
                            cost 41 minutes. According to our test, we provided a knowledge-based table (Table 1) and
                            fitted curve figure (Figure 4) to show the processing time.
                        </li>
                        <br>
                        Table 1. Statistical analysis of Cavity computing time.
                        <table class="ui celled table">
                            <tr>
                                <th>Number of residues in protein</th>
                                <th>Predicted Running time(Unit: minute)</th>
                            </tr>
                            <tr>
                                <td><400</td>
                                <td>Usually less than 3 minutes</td>
                            </tr>
                            <tr>
                                <td>400-500</td>
                                <td>2-5</td>
                            </tr>
                            <tr>
                                <td>500-600</td>
                                <td>4-7</td>
                            </tr>
                            <tr>
                                <td>600-800</td>
                                <td>6-9</td>
                            </tr>
                            <tr>
                                <td>800-1000</td>
                                <td>9-15</td>
                            </tr>
                            <tr>
                                <td>>1000</td>
                                <td>Usually longer than 15 minutes. The larger the protein, the longer the running
                                    time.
                                </td>
                            </tr>
                        </table>
                        <img src="imgs/3_1.png" width="80%"><br>
                        Figure 4. The scatter plot and fitted curve of Cavity processing time against the number of
                        protein.
                        <br><br><br>


                        <li>After finished, the results will be shown in the "Cavity Results" part at the bottom of the
                            JSmol window (shown in Figure 5). The result table will list the DrugScore and Druggability for each cavities. Users can click the Checkbox in Surface column to view each cavity in JSmol window. The last column provides the information of residues that constitute the cavity. Users can get the information by clicking "More" and copy the residues information directly, rather than downloading the results.
                        </li>
                        <br>
                        <img src="imgs/4.png" width="45%"><img src="imgs/5.png" width="45%"><br>
                        Figure 5. Visualization of Cavity Results. Once a checkbox in the Red rectangle is selected, the JSmol window will show the current cavity.
                        <br><br>

                        <li>CAVITY will output the following visual files for viewing the detection result.</li>
                        <ol>
                        <li>name_surface.pdb: The output file storing the surface shape of the
                            binding-site and the CavityScore. It is in PDB format, and user can use
                            molecular modeling software to view this file and obtain an insight into
                            the geometrical shape of the binding site. User can view this file by
                            plain text editor, and check the predicted maximal pKd of the binding
                            site. This value indicated the ligandability of the binding site. If
                            it is less than 6.0(Kd is 1uM), suggests that this binding-site may be
                            not a suitable drug design target.
                        </li>
                        <li>name_vacant.pdb: The output file storing the volume shape of the
                            binding-site. It is in PDB format, and user can use molecular modeling
                            software to view this file and obtain an insight into the geometrical
                            shape of the binding site.
                        </li>
                        <li>name_cavity.pdb: The output file storing the atoms forming the
                            binding-site. It is in PDB format, and user can use molecular modeling
                            software to view this file and obtain an insight into the residues of
                            the binding site. It is the visual version of "name_pocket.txt".
                        </li>
                        </ol>

                        <b>Note</b>: Some molecular modeling software may not display these files
                        correctly, please try different software if you could not view the
                        results file. (Pymol is recommended to support these output files.)<br><br>
                        <a href="#test0">Back to top </a>


                        </p>
                    </section>
                    <section class="tutorial-section" id="test2">
                        <h3 class="h3-tutorial">CavPharmer</h3>
                        <p class="p-tutorial">
                        <h3 style="color:blue;">Step 1</h3>
                        <p>To use CavPharmer, CAVITY module <b style="color: blue">MUST</b> be executed at first. When
                            Cavity finished successfully, a list of cavity results will be shown below the "Select a
                            cavity" label. Please select one result as input to generate pharmacophores; Once the radio button is selected, the JSmol window will show the residues of the selected cavity (shown in Figure 6).<br>
                            <img src="imgs/6.png" width="85%"><br>
                            Figure 6. Visualization of CavPharmer operation interface. Red ellipse part shows the selected residues.
                            <br><br>

                        <h3 style="color:blue;">Step 2</h3>
                        Select mode.
                        <li>Pharmacophore Module can be used for either receptor-based or ligand-based
                        pharmacophore generation. "With Ligand" should be selected and a ligand need to be uploaded
                        if ligand-based pharmacophore generation is expected. </li>
                        <li>The Ligand provided to CavPharmer should also be a prepositioned ligand in the input cavity. Just like CAVITY, we automatically extract all ligands in protein and users can select the proper one as CavPharmer input if “With Ligand” was selected. </li>


                        <h3 style="color:blue;">Step 3</h3>
                        <li>Run CavPharmer program by clicking "Submit" button. Some information is provided in "CavPharmer Results" part. The pharmacophore model on each cavity could be recorded in the "show option" (shown in Figure 7). </li>
                        <li>Running time of CavPharmer depends on the size of input cavity. We tested our CavPharmer with the results of CAVITY test. Seventy-seven cases among 100 finished in one minutes, while one case with a very large cavity cost 18 minutes. Please be patient to wait the program finishes especially when a large cavity is provided. </li>
                        <img src="imgs/7.png" width="85%"><br>
                        Figure 7. Visualization of CavPharmer Results. Results can be recorded in the red rectangle sequentially.Different colors represent different pharmacophores. Blue and red spheres represent the H-bond
                        donor center and h-bond acceptor, respectively; green spheres: hydrophobic center; olive
                        spheres: positive electrostatic center; grey spheres: negative electrostatic center.
                        <br>
                        <a href="#test0">Back to top </a>


                        </p>
                    </section>

                    <section class="tutorial-section" id="test3">
                        <h3 class="h3-tutorial">CorrSite</h3>
                        <p class="p-tutorial">

                        <h3 style="color:blue;">Step 1</h3>
                        <p>Set the orthosteric sites: <br>
                            1. Cavity pockets: results of CAVITY module. Select the one that you are interested. <br>
                            2. Custom pockets: Upload one PDB file of orthosteric sites. <br>
                            3. Custom residues: This server also support the custom <b style="color:blue">.txt </b>
                            file, like
                            the following formats: (residueID: ChainID) <br>
                            46:A;47:A;49:A
                            or <br>
                            46:A <br>
                            47:A <br>
                            49:A <br>
                            <img src="imgs/8.png" width="30%"><br>
                        Figure 8. Visualization of CorrSite input format.

                        <h3 style="color:blue;">Step 2</h3>
                        Run program by clicking "Submit" button (It will takes only less than 30s). <br>
                        <img src="imgs/9.png" width="85%"><br>
                        Figure 9. Visualization of CorrSite results. The stick region on the protein marked in red ellipse is the orthosteric site. The other region is corresponding to two allosteric sites. The score marked in a red rectangle in the "CorrSite Results" is a correlation score with the orthosite for the current cavity. When the score more than 0.5 (in pink color), this cavity may be a potential allosteric site. <br>
                        <a href="#test0">Back to top </a>


                        </p>
                    </section>

                    <section class="tutorial-section" id="test4">
                        <h3 class="h3-tutorial">CovCys</h3>
                        <p class="p-tutorial">
                        <h3 style="color:blue;">Step 1</h3>
                        <p>The input of this module are all the cavity results detected by the CAVITY program. Run
                            CAVITY first, then click "Run CovCys" button, the results will be shown the "CovCys Results"
                            part. <br>
                            <img src="imgs/10.png" width="50%"><br>
                            Figure 10. Visualization of CovCys results. Some key features are shown in the above table. <br>
                        <li>ResID: cysteine residues ID of the protein;</li>
                        <li>CavID: the cavity ID detected by the CAVITY program;</li>
                        <li>Cov: the annotation predicted by the pre-trained SVM model. </li>
                        <li>Prob: the probability of being a covalent targetable cysteine. </li>
                        <li>pKa: the pKa value predicted by the PROPKA program; </li>
                        <li>QSASA: the exposure degree of the cysteine. It is calculated by dividing the solvent
                            accessible surface area (SASA) of this cysteine with the theoretical SASA. The SASA is
                            calculated by the Pops program. </li>
                        <li>pKdAve: the average binding affinity of the pocket associated, which is calculated by
                            CAVITY. </li>
                            <a href="#test0">Back to top </a>
                            <br>
                        </p>
                    </section>


                    <h1>Download</h1>
                    <img src="imgs/11.png" width="30%"><img src="imgs/11_1.png" width="30%"><br>
                    Figure 11. Visualization of Download list.

                    The "Download" button is used to download the results of finished tasks. <br>
                    <a href="#test0">Back to top </a>


                    <h1><b style="font-size: 24px;color: blue"><a href="./computation.php">Just try it now </a></b>
                    </h1>

                </div>
            </div>
        </div>
    </div>
</section>


<section id="publications" class="bg-light-gray">
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
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Contact us</h2>
                <h3 class="section-subheading text-muted bottom-margin-sm"></h3>
                <a target="_blank" href="mailto:jfpei@pku.edu.cn" class="btn btn-xl">Contact</a>
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
                <p class="grey-text text-align-left">
                    <?php
                    session_start();
                    echo $_SESSION['counter'];
                    ?>

                </p>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <h5 class="white-text">Email</h5>
                <p class="text-align-left"><a class="grey-text"
                                              href="mailto:BioinfoF@cqb.pku.edu.cn">jfpei@pku.edu.cn</a></p>
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


<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>


<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="js/agency.min.js"></script>


</body>

</html>
