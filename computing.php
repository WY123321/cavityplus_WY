<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Corrsite</title>
    <script type="text/javascript" src="resource/js/jsmol/JSmol.min.js"></script>


    <!--<link href="resource/css/select.css" rel="stylesheet" type="text/css"/>-->
    <link href="resource/css/main.css" rel="stylesheet" type="text/css"/>
    <!--    <link href="resource/css/mystyle.css" rel="stylesheet" type="text/css"/>-->
    <!--    <link href="resource/semancui/semantic.css" rel="stylesheet" type="text/css"/>-->
    <link href="Semantic-UI-CSS-master/semantic.min.css" rel="stylesheet" type="text/css">
    <link href="resource/mystyle.css" rel="stylesheet" type="text/css">

    <script src="resource/js/jquery/jquery.js"></script>
    <script src="Semantic-UI-CSS-master/semantic.min.js"></script>
    <!--    <script src="assets/library/iframe.js"></script>-->
    <script type="text/javascript" src="resource/FileSaver/FileSaver.js"></script>
    <script type="text/javascript" src="resource/js/jquery.ajaxfileupload.js"></script>
    <link href="resource/tablesorter/css/theme.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="resource/tablesorter/css/theme.default.css" rel="stylesheet"
          type="text/css"/>
    <script type="text/javascript"
            src="resource/tablesorter/js/jquery.tablesorter.js"></script>
    <script type="text/javascript"
            src="resource/tablesorter/js/jquery.tablesorter.widgets.js"></script>
    <script type="text/javascript" src="resource/js/3Dmol/3Dmol-min.js"></script>
    <!--    <script type="text/javascript" src="http://162.105.160.28:80/cavity/resource/js/jscolor/jscolor.js"></script>-->
    <script type="text/javascript" src="my3Dmol.js"></script>
    <script type="text/javascript" src="myJSscript.js"></script>

    <?php
    session_start();
    $sessws = $_SESSION['sessws'];
    ?>
</head>

<body>


<div class="ui padded grid">
    <div class="eleven wide column">
        <div class="ui segment">
            <div style="height: 450px; width: 100%; position: relative;" id="div_mol"></div>
        </div>


        <div>
            <div class="ui styled fluid accordion" id="result_accordion_module">
                <div class="title" id="CavityResulttilte"><i class="dropdown icon"></i> Cavity Results</div>
                <div class="content" id="CavityResultcont">
                    <form id="cavityresultform">
                        <div class="ui container" id="entry3" style="display: none;">
                            <table class="table" id="resultTable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pred. Max pKd
                                        <span class="help-tip"><p>
                                        This value indicates the ligandability of a cavity binding site. A value less than 6.0 suggests that this may be not a suitable binding site.
                                    </p></th>
                                    <th>Pred. Avg pKd
                                        <!--<span class="help-tip"><p> </p>-->
                                    </th>
                                    <th>DrugScore</th>
                                    <th>Druggability
                                        <span class="help-tip"><p>
				    This value indicates the possibility of a cavity binding site to be druggable or not.
                                    </p></th>
                                    <th>Surface
                                        <span class="help-tip"><p>
                                    The geometrical shape of a cavity binding site.
                                    </p></th>
                                    <th>Residues
                                        <span class="help-tip"><p>
                                The residues that constitute a cavity.
                                    </p></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                        <div id="cavity_noresults" style="display: none;"></div>
                    </form>


                </div>
                <div class="title" id="PocketResulttilte">
                    <i class="dropdown icon"></i> CavPharmer Results
                </div>
                <div class="content" id="PocketResultcont">
                    <form>
                        <div class="ui container" id="entrypocket" style="display:none;">
                            <label> Show option: </label>
                            <div id="checkbox_showpockets"></div>
                            <br>
                            <div id="show_pharma_table"></div>
                        </div>
                    </form>


                </div>
                <div class="title" id="CorrsiteResulttitle">
                    <i class="dropdown icon"></i> CorrSite Results
                </div>
                <div class="content" id="CorrsiteResultcont">

                    <form id="corrsiteResultForm">
                        <!-- <div id="corrsiteResultDiv"></div> -->

                        <table class="ui striped table" id="corrResultTable">
                            <thead>
                            <tr>
                                <th class="two wide">Orthosite
                                </th>
                                <th class="fourteen wide">Allosites <span class="help-tip"><p>
                                Cavity(id):(Z-Score). A cavity with Z-score more than 0.5 is predicted as a potential allosteric site (marked in pink color).
                                    </p></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>

                    <div id='corrsite_noresults'></div>


                </div>

                <div class="title" id="CyspredResulttitle">
                    <i class="dropdown icon"></i> CovCys Results
                </div>
                <div class="content" id="CyspredResultcont">
                    <form id="covcysresultform">
                        <div class="ui container" id="entry4" style="display: none;">
                            <table class="table" id="csv_table" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>ResID</th>
                                    <th>CavID
                                        <span class="help-tip"><p>
                                    The number of a pocket detected by the CAVITY module.
                                    </p></th>
                                    <th>Cov.
                                        <span class="help-tip"><p>
                                    The annotation of a covalent targetable cysteine predicted by a SVM model.
                                    </p></th>
                                    <th>Prob.
                                        <span class="help-tip"><p>
                                    The probability of being a covalent targetable cysteine generated by a SVM model.
                                    </p></th>
                                    <th>pKa
                                        <span class="help-tip"><p>
                                    The pKa value predicted by the PROPKA method.
                                    </p></th>
                                    <th>QSASA
                                        <span class="help-tip"><p>
                                    The exposure area of a cysteine. It is calculated by dividing the solvent accessible surface area (SASA) of a cysteine by the theoretical SASA. The SASA is calculated by the Pops method.
                                    </p></th>
                                    <th>pKdAve
                                        <span class="help-tip"><p>
                                    The average ligandability of a cavity. It is calculated by the CAVITY module.
                                    </p></th>
                                    <th>Show</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </form>
                    <div id="cyspred_noresults"></div>

                </div>
            </div>
        </div>

    </div>


    <div class="five wide column">
        <div class="treemenu boxed">
            <div class="ui styled fluid accordion" id="operation">
                <div class="active title" id="cavityTitle">
                    <i class="dropdown icon"></i>
                    <b>Cavity</b>
                </div>
                <div class="active content" id="cavityContent">

                    <div class="ui inline field">
                        <div class="ui action left icon input">
                            <div class="ui button" style="background-color: lightskyblue;">InputType</div>
                            <select class="ui compact dropdown" onchange="" id="cavitySelect">
                                <option value="entry">PDBEntry</option>
                                <option value="file">PDBFile</option>
                            </select>

                        </div>
                        <a class="ui icon button" href="2amd.pdb"><i class="cloud download icon"></i>Example</a>
                    </div>

                    <br>

                    <form>
                        <div class="ui input" id="PDBEntry">
                            <input class="ui mini input" type="text" placeholder="PDB ID: 2amd" id="PDBEntry_ID"
                                   onkeyup="value=value.replace(/[\W]/g,'');value=value.toUpperCase();"
                                   onpaste="return false" maxlength="4">
                            <button class="ui mini icon button" style="background-color: lightskyblue;"
                                    id="PDBEntry_Btn" type="button"><i class="search icon"></i>Click it to search
                            </button>
                        </div>
                        <div id="showloading"></div>

                        <div class="ui mini input" id="PDBFile" style="display: none">
                            <label>
                                <div class="ui mini icon button"> Protein input (*.pdb)</div>
                                <input type="file" id="PDBFile_ID" accept=".pdb"/>
                            </label>
                        </div>


                    </form>

                    <!--                    <form method="post" id="cavityForm" enctype="multipart/form-data">-->
                    <!--                        <div class="ui input">-->
                    <!--                            <a class="ui label" id="selectchains"-->
                    <!--                               style="text-align: center; background-color: lightskyblue">Chain(s)</a>-->
                    <!--                            <div id="content"></div>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                        <div class="ui hidden hidden divider"></div>-->
                    <!--                        <div class="ui input" id="mode">-->
                    <!--                            <div class="ui text">-->
                    <!--                                <div>-->
                    <!--                                    <span style="width: 80px;"><strong>Mode</strong></span>-->
                    <!--                                    <span class="help-tip">-->
                    <!--                                 <p>Ligand file should be uploaded if the mode is "With Ligand".</p>-->
                    <!--                                </span>-->
                    <!--                                    <input value="0" id="cmode-1" type="radio" name="cmode" checked="checked"-->
                    <!--                                           onclick="selectCavityMode()"/>-->
                    <!--                                    <label for="cmode-1">No Ligand</label>-->
                    <!--                                    <input value="1" id="cmode-2" type="radio" name="cmode"-->
                    <!--                                           onclick="selectCavityMode()">-->
                    <!--                                    <label for="cmode-2">With Ligand</label>-->
                    <!---->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!---->
                    <!--                        </div>-->
                    <!--                        <div class="ui hidden hidden divider"></div>-->
                    <!---->
                    <!--                        <div id="Cligfile" style="display: none">-->
                    <!--                            <div class="ui mini input">-->
                    <!--                                <div class="ui mini icon button">Ligand(s)</div>-->
                    <!--                                <div id="curligand_content">-->
                    <!--                                     js show the contant -->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!---->
                    <!--                            <div class="ui hidden hidden divider">OR</div>-->
                    <!---->
                    <!--                            <label>-->
                    <!--                                <div class="ui mini icon button">Ligand input (*.mol2)</div>-->
                    <!--                                <input class="ui mini input" type="file" name="ligfile" id="ligandFile"/>-->
                    <!--                            </label>-->
                    <!--                        </div>-->
                    <!---->
                    <!---->
                    <!--                        <div class="accordion">-->
                    <!--                            <div class="title">-->
                    <!--                                <i class="dropdown icon"></i> Advanced parameters-->
                    <!--                            </div>-->
                    <!--                            <div class="content">-->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        SEPARATE_MIN_DEPTH-->
                    <!--                                        <span class="help-tip"><p>Default minimal depth of binding-site. Linkage between sub-cavity that do not reach this critical will be cut.</p></span>-->
                    <!--                                    </div>-->
                    <!--                                    <input id="SMD" name="SMD" value="8" type="text" class="size" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="ui basic label" style="border: none;">Å</div>-->
                    <!--                                </div>-->
                    <!---->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        MAX_ABSTRACT_LIMIT-->
                    <!--                                        <span class="help-tip"><p>Default abstract surface area. Increase this value if the real binding site is much larger than the detection result, and vice-versa.</p></span>-->
                    <!--                                    </div>-->
                    <!--                                    <input id="MAL" name="MAL" value="1500" type="text" class="active" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="ui basic label" style="border: none;">Å<sup>3</sup></div>-->
                    <!--                                </div>-->
                    <!---->
                    <!---->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        SEPARATE_MAX_LIMIT-->
                    <!--                                        <span class="help-tip"><p>Default surface area. Increase this value if the real binding site is much larger than the detection result, and vice-versa.</p></span>-->
                    <!--                                    </div>-->
                    <!--                                    <input id="SML" name="SML" value="6000" type="text" class="active" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="ui basic label" style="border: none;">Å<sup>3</sup></div>-->
                    <!--                                </div>-->
                    <!---->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        MIN_ABSTRACT_DEPTH-->
                    <!--                                        <span class="help-tip"><p>Default abstract depth. Increase this value if the real binding site is much larger than the detection result, and vice-versa.</p></span>-->
                    <!--                                    </div>-->
                    <!--                                    <input id="MAD" name="MAD" value="2" type="text" class="active" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="ui basic label" style="border: none;">Å</div>-->
                    <!--                                </div>-->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        RULER_1-->
                    <!--                                        <span class="help-tip"><p>Limt the minimum volume.</p></span><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0.125×</label>-->
                    <!--                                    </div>-->
                    <!--                                    <input id="R1" name="R1" value="100" type="text" class="active" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="ui basic label" style="border: none;">Å<sup>3</sup></div>-->
                    <!--                                </div>-->
                    <!--                                <div class="ui labeled input">-->
                    <!--                                    <div class="ui label"-->
                    <!--                                         style="font-size: 10px;color: black;background-color: whitesmoke;width: 153px;">-->
                    <!--                                        OUTPUT_RANK-->
                    <!--                                        <span class="help-tip"><p>Limit the minimum score.</p></span></div>-->
                    <!--                                    <input id="OR" name="OR" value="1.5" type="text" class="active" size="4"-->
                    <!--                                           style="text-align: right;">-->
                    <!--                                    <div class="basic label"></div>-->
                    <!--                                </div>-->
                    <!---->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="ui hidden hidden divider"></div>-->
                    <!--                        <div style="text-align: center;" id="subcavop">-->
                    <!--                            <button class="ui button" type="submit" id="submitCavity"-->
                    <!--                                    style="background-color: lightskyblue;">-->
                    <!--                                Submit-->
                    <!--                            </button>-->
                    <!---->
                    <!--                            <div class="ui active inline loader" id="cavityrunningshow">Running Cavity...</div>-->
                    <!--                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                    <!--                            <button class="ui button" id="checkcavitybar" style="display: none;">-->
                    <!--                                Check-->
                    <!--                            </button>-->
                    <!--                            <div class="ui hidden hidden divider"></div>-->
                    <!--                            <div id="timerapp"></div>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                    </form>-->


                </div>

                <div class="title" id="cavPharmerTitle">
                    <i class="dropdown icon"></i> <b>CavPharmer</b>
                </div>
                <div class="content" id="cavPharmerContent">
                    <div>cavPharmer</div>
                    <!--                    <h4 class="ui header"> Select a cavity: </h4>-->
                    <!--                    <form id="myFormcavity">-->
                    <!--                        <div id="Cavityoutput" style="text-align: center"></div>-->
                    <!--                    </form>-->
                    <!---->
                    <!--                    <div class="ui hidden divider"></div>-->
                    <!---->
                    <!--                    <form class="ui form" id="pocketForm">-->
                    <!---->
                    <!--                        <div class="ui input" id="modePoc">-->
                    <!--                            <div class="ui text">-->
                    <!--                                <div>-->
                    <!--                                    <span style="width: 80px;"><strong>Mode</strong></span>-->
                    <!--                                    <span class="help-tip">-->
                    <!--                                 <p>Ligand file should be uploaded if the mode is With Ligand.</p>-->
                    <!--                                </span>-->
                    <!--                                    <input value="0" id="cmode-1Poc" type="radio" name="cmodePoc" checked="checked"-->
                    <!--                                           onclick="selectCavityModePoc()"/>-->
                    <!--                                    <label for="cmode-1Poc">No Ligand</label>-->
                    <!--                                    <input value="1" id="cmode-2Poc" type="radio" name="cmodePoc"-->
                    <!--                                           onclick="selectCavityModePoc()"/>-->
                    <!--                                    <label for="cmode-2Poc">With Ligand</label>-->
                    <!---->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!---->
                    <!--                        </div>-->
                    <!--                        <div class="ui hidden divider"></div>-->
                    <!---->
                    <!--                        <div id="CligfilePoc" style="display: none">-->
                    <!--                            <div class="ui mini input">-->
                    <!--                                <div class="ui mini icon button">Ligand(s)</div>-->
                    <!--                                <div id="curligand_content_inCavPharmer">-->
                    <!--                                     js show the contant -->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!---->
                    <!--                            <div class="ui hidden hidden divider">OR</div>-->
                    <!---->
                    <!---->
                    <!--                            <label>-->
                    <!--                                <div class="ui mini icon button">Ligand input (*.mol2)</div>-->
                    <!--                                <input class="ui mini input" type="file" name="ligfile" id="ligandFilepoc"/>-->
                    <!--                            </label>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                        <div class="ui hidden divider"></div>-->
                    <!---->
                    <!--                        <div style="text-align: center;display: none;" id="subpocop">-->
                    <!--                            <button class="ui button" type="submit" id="submitPocket"-->
                    <!--                                    style="background-color: lightskyblue;">-->
                    <!--                                Submit-->
                    <!--                            </button>-->
                    <!--                            <div class="ui active inline loader" id="pocketrunningshow">Running...</div>-->
                    <!--                        </div>-->
                    <!--                    </form>-->
                    <!---->
                    <!---->
                </div>

                <div class="title" id="corrSiteTitle">
                    <i class="dropdown icon"></i> <b>CorrSite</b>
                    <span class="help-tip"><p>
                                                The current CorrSite is just applicable to monomeric proteins. If your protein has multiple chains, please choose one chain for prediction.
                                                </p>
                </div>
                <div class="content" id="corrSiteContent">
                    <div>corrsite</div>
                    <!--                    <h4 class="ui header"> Select an orthosite: </h4>-->
                    <!--                    <div class="ui action left icon input">-->
                    <!--                        <div class="ui button" style="background-color: lightskyblue">ActiveSiteType</div>-->
                    <!--                        <select class="ui compact dropdown" onchange="selectactiveInputType()"-->
                    <!--                                id="activeTypeValuePoc"-->
                    <!--                                name="inputType">-->
                    <!--                            <option value="1">Cavity pockets</option>-->
                    <!--                            <option value="2">Custom pockets</option>-->
                    <!--                            <option value="3">Custom residues</option>-->
                    <!--                            <option value="3">Cavity detection</option>-->
                    <!--                        </select>-->
                    <!---->
                    <!---->
                    <!--                    </div>-->
                    <!---->
                    <!---->
                    <!--                    <form id="myFormCorrsite">-->
                    <!--                        <div class="ui hidden divider"></div>-->
                    <!--                        <div id="cavitycorrsiteOP">-->
                    <!--                            <div id="CavityoutputInCS" style="text-align: center"></div>-->
                    <!--                        </div>-->
                    <!--                    </form>-->
                    <!---->
                    <!--                    <form>-->
                    <!--                        <div class="ui mini input" id="asPDBcorrsiteOP" style="display: none">-->
                    <!---->
                    <!--                            <label>-->
                    <!--                                <div class="ui mini icon button"> Pocket input (*.pdb)</div>-->
                    <!--                                <input class="ui mini input" type="file" name="cavityfile"-->
                    <!--                                       id="activesiteFilecorrsite"/>-->
                    <!--                            </label>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                        <div class="ui mini input" id="RescorrsiteOP" style="display: none">-->
                    <!---->
                    <!--                            <label>-->
                    <!--                                <div class="ui mini icon button"> Residue input (*.txt)</div>-->
                    <!--                                <input class="ui mini input" type="file" name="residuefile" id="activeRescorrsite"/>-->
                    <!--                            </label>-->
                    <!--                        </div>-->
                    <!---->
                    <!---->
                    <!--                        <div class="ui hidden divider"></div>-->
                    <!--                    </form>-->
                    <!---->
                    <!---->
                    <!--                    <form>-->
                    <!--                        <div style="text-align: center;display: none;" id="subcorrop">-->
                    <!--                            <button class="ui button" type="submit" id="submitCorrsite"-->
                    <!--                                    style="background-color: lightskyblue;">-->
                    <!--                                Submit-->
                    <!--                            </button>-->
                    <!--                            <div class="ui active inline loader" id="corrsiterunningshow">Running...</div>-->
                    <!--                        </div>-->
                    <!--                    </form>-->
                    <!---->
                    <!---->
                </div>

                <div class="title" id="covCysTitle">
                    <i class="dropdown icon"></i> <b>CovCys </b>
                </div>
                <div class="content" id="covCysContent">
                    <div>covCys</div>
                    <!--                    <form>-->
                    <!--                        <div style="text-align: center;display: none;" id="subcysop">-->
                    <!--                            <button class="ui button" type="submit" id="submitCyspred"-->
                    <!--                                    style="background-color: lightskyblue;">-->
                    <!--                                Run CovCys-->
                    <!--                            </button>-->
                    <!---->
                    <!--                            <div class="ui active inline loader" id="cyspredrunningshow">Running...</div>-->
                    <!--                        </div>-->
                    <!---->
                    <!---->
                    <!--                    </form>-->
                </div>

            </div>
        </div>

        <div class="ui hidden divider"></div>

        <div class="ui segment" id="downloadop" style="display:none;">
            <label style="font-weight:bold;">Finished computation list: </label><br>
            <div id="downloadlist"></div>
            <div class="ui container" style="text-align: center">
                <div class="ui button" id="downloadBtn" style="background-color: lightskyblue">Download</div>
            </div>
        </div>


    </div>


</div>


</body>
</html>
