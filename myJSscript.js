(function ($) {


    $(function () {
        $('.ui.checkbox').checkbox();
        $('#mainoperation').accordion({exclusive: false});
        $('.treemenu').toggleClass('boxed');
        $('#cavityrunningshow').hide();
        // $('.ui.teal.button').popup({on: 'click'})


    });


    var sessionid = "";
    $.ajax({
        type: 'POST',
        url: "counter.php",
        success: function (response) {
            sessionid = response;
            document.getElementById("counter").innerHTML = "There has been " + response + " visitors accessing the server";
        }
    });


    var sessionworkname = "";

    $.ajax({
        type: 'POST',
        url: "getsessionname.php",
        async: false,
        success: function (response) {
            sessionworkname = response;
        }
    });

// alert(sessionworkname);


    var JmolPath = "resource/js/jsmol/";
    var JmolMode, JmolInfo, myJmol = 'myJmol';
    var pocketsubmitorder = new Array();
    var countmodel = 1;

    var covcyscountmodel = 1;
    var curmodelrecords = [];
    var covcysframemap = [];
    var covcysresmap = [];

    var initialScript = "if (_is2D) {set hermitelevel 0} else {set hermitelevel 6;set ribbonAspectRatio 4};frank off;set appendNew true;set zoomlarge false;set antialiasDisplay;";


    var initialframe = "select {1.1}; cartoons only; color chain;"
    var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";

    var refreshcavitymodel = 1;
    var refreshpocketmodel = 1;
    var refreshcorrsitemodel = 1;


    var corrsitelistnum = 0;
    var corrsiteorthores = [];


    var cyscovshowlist = [];


    var colornames = new Array("#B766AD", "#A6A6D2", "#DDA0DD", "#87CEEB", "#9932CC", "#7B68EE", "#6A5ACD", "#483D8B", "#4169E1", "#6495ED", "#778899", "#4682B4", "#87CEFA", "#87CEEB", "#5F9EA0", "#AFEEEE", "#48D1CC", "#3CB371", "#FAFAD2", "#EEE8AA", "#BDB76B", "#D2B48C", "#CD853F", "#FF7F50", "#FF6347", "#F08080", "#CD5C5C", "#A52A2A", "#8B0000", "#C0C0C0", "#808080");

// var addpocketcmd='load append \"pkout.pdb\"; model 2.1; select POK and not *.b; spacefill; color property atomno; select *.b; isosurface solvent; color isosurface chain; frame *; display 1.1,2.1';


// var proteincmd= 'load resource/data/1g58.pdb;cartoons only;color chain;';

    $(document).ready(function () {

        var proteincmd = 'load 1db4.pdb;cartoons only;color structure;javascript readChainsInfo();';
        // var addpocketcmd='load append \"pkout.pdb\"; model 2.1; select POK and not *.b;spacefill only; color group;select *.b; isosurface solvent; color isosurface chain; frame *; display 1.1,2.1';
        JmolInfo = {
            width: "100%",
            height: 450,
            color: "white",
            j2sPath: JmolPath + 'j2s',
            jarPath: JmolPath + 'java',
            jarFile: 'JmolAppletSigned0.jar',
            isSigned: true,
            use: "HTML5",
            serverURL: JmolPath + 'php/jsmol.php',
            disableJ2SLoadMonitor: true,
            disableInitialConsole: true,
            script: initialScript + proteincmd
        };
        $('#mol').html(Jmol.getAppletHtml(myJmol, JmolInfo));
    });

    function get_ligandsets_html_fromPDB(mypdbstring, dropdownid) {
        var mylinearray = mypdbstring.split("\n");
        var ligsets = {};
        var Regx = /^HETATM/;
        for (var i in mylinearray) {
            // for (var i = 0; i < 5; i++){
            if (Regx.test(mylinearray[i])) {
                liglabel = mylinearray[i].substring(17, 20).replace(/\s/g, "");
                ligchain = mylinearray[i].substring(21, 22);
                ligid = mylinearray[i].substring(22, 26).replace(/\s/g, "");
                ligsets[liglabel + ligchain] = ligchain + ":" + ligid;
                // alert(ligsets);
            }
        }
        var dict = ligsets;
        var labels = [];
        var tmp = '<div class="ui compact mini selection dropdown" id=' + dropdownid + '><input type="hidden" name="mylignad"><i class="dropdown icon"></i><div class="default text">--select--</div><div class="menu"> <div class="item" data-value="">--select--</div>';
        if (ligsets.length != 0) {
            for (var key in dict) {
                // var value = dict[key];
                // labels.push(key)
                var key1 = key.substring(0, key.length - 1);
                tmp = tmp + '<div class="item" data-value="' + key + '">' + key1 + '-' + dict[key] + '</div>';
                // alert(key);
                // alert(tmp);
            }
        }
        // alert(labels);
        tmp = tmp + '</div></div>';
        // alert(tmp);
        return tmp;
    }

    function show_main_accordion(currentswitch) {
        //all close;
        if (currentswitch == 0) {
            $('#CavityResulttilte').removeClass('active');
            $('#CavityResultcont').removeClass('active');
            $('#PocketResulttilte').removeClass('active');
            $('#PocketResultcont').removeClass('active');
            $('#CorrsiteResulttitle').removeClass('active');
            $('#CorrsiteResultcont').removeClass('active');
            $('#CyspredResulttitle').removeClass('active');
            $('#CyspredResultcont').removeClass('active');
        }


        // the first open
        if (currentswitch == 1) {
            $('#cavitytitle').addClass('active');
            $('#cavitycont').addClass('active');

            $('#pockettitle').removeClass('active');
            $('#pocketcont').removeClass('active');

            $('#corrsitetitle').removeClass('active');
            $('#corrsitecont').removeClass('active');

            $('#cyspredtitle').removeClass('active');
            $('#cyspredcont').removeClass('active');
            $('#submitPocket').hide();
            $('#submitCorrsite').hide();
            $('#submitCyspred').hide();


        }


    };


// get the PDB file from the RSCB;
    function loadPDB() {
        var proteinId = $("#proteinID").val();

        if (proteinId.length == 4) {
            // Jmol.scriptWait(myJmol, "script pre.txt;");
            $('#showloading').html(proteinId + " loading...");

            setTimeout(function () {
                var cmd = "load " + "\"=" + proteinId + "\";select all;cartoons only;color structure; javascript readChainsInfo();";
                var cmd1 = initialScript + cmd;
                Jmol.scriptWait(myJmol, cmd1);
                $('#checkbox_showpockets').html("");
                var selected_PDB = Jmol.scriptWaitAsArray(myJmol, "select protein; write PDB")[0][0][3];
                // var selected_ligand = Jmol.scriptWaitAsArray(myJmol, "select hetero and (not water); write PDB")[0][0][3];

                data = {"text": selected_PDB, "filename": sessionworkname + "/" + proteinId + ".pdb"};
                writePDB(data);
                alert(proteinId + " has been successfully loaded.");
                $('#showloading').html(proteinId + " loaded.");
                $('#timerapp').html("");
                $('#downloadlist').html("");
                show_main_accordion(1);
                show_main_accordion(0);

            }, 100);
        } else {
            alert("It is not a valid PDB ID.");
            $('#showloading').html("load error.");
        }

    }


//get the info of chain for a protein, and show it with checkbox.
    function readChainsInfo() {
        var chains = Jmol.scriptWaitAsArray(myJmol, "select protein or nucleic;show CHAIN")[0][0][3].split("\n");
        chains.pop();
        var chainContent = "";
        var Regx = /[A-Z]/;

        // alert("chain:"+ chains.length);
        if (Regx.test(chains[0])) {
            var check_val = [];
            $(chains).each(function (index, data) {
                var chain = data;
                var template = '<div class="ui checkbox"><input class="group1" tabindex="0" type="checkbox"  checked="checked" name="chains" value="' + chain + '"> 	<label>' + chain + '</label> </div> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;';
                chainContent += template;
                check_val.push(":" + chain);
            });
            $("#content").html("");
            $("#content").html(chainContent);
            $('.ui.checkbox').checkbox();
            cmd_selectchains1 = 'select (' + check_val.join() + ') and hetero and (not water); write PDB';
            var selected_ligand = Jmol.scriptWaitAsArray(myJmol, cmd_selectchains1)[0][0][3];
            var tmp = get_ligandsets_html_fromPDB(selected_ligand, "Cavity_dropdown");
            var tmp1 = get_ligandsets_html_fromPDB(selected_ligand, "CavPharmer_dropdown");

            $('#curligand_content').html("");
            $('#curligand_content').html(tmp);
            $('#curligand_content_inCavPharmer').html("");
            $('#curligand_content_inCavPharmer').html(tmp1);
            $('.ui.dropdown').dropdown();

        } else {
            alert("Please add chain id to your pdf file!");
            window.location.reload();
        }

    }

// write selected structure and move it to the session directory;
    function writePDB(data) {
        var resnum = 0;
        $.ajax({
            type: 'POST',
            url: "savefile.php",
            data: data,
            async: false,
            success: function (data) {
                resnum = data;
            }
        });
        return resnum;
    }


// show the operation way for requiring a protein;
    function selectInputType() {
        $('#showloading').html("");

        var type = $("#typeValue").val();
        if (type == 1) {
            $("#entry").show();
            $("#file").hide();
        }
        if (type == 2) {
            $("#file").show();
            $("#entry").hide();
        }

    }


    function selectCavityMode() {
        var mode = $("input[type='radio'][name='cmode']:checked").val();
        if (mode == 0) {
            $("#Cligfile").hide();
        }
        if (mode == 1) {
            // detemine the selected chain(s)
            // var obj = document.getElementsByName("chains");
            // var check_val = [];
            // var cmd_selectchains = "select ";
            // // var selected_PDB = "";
            // for (var k in obj) {
            //     if (obj[k].checked) {
            //         check_val.push(':' + obj[k].value);
            //     }
            // }
            // if (check_val.length != 0) {
            //     cmd_selectchains = cmd_selectchains + check_val.join() + ' and hetero and (not water); write PDB';
            //     var selected_ligand = Jmol.scriptWaitAsArray(myJmol, cmd_selectchains)[0][0][3];
            //     var tmp=get_ligandsets_html_fromPDB(selected_ligand);
            //     $('#curligand_content').html("");
            //     $('#curligand_content').html(tmp);
            //     $('.ui.dropdown').dropdown();
            // } else {
            //     Jmol.script(myJmol, 'restrict none; cartoon');
            // }
            $("#Cligfile").show();
        }
    }


// show the operation way for requiring orthosites;
    function selectactiveInputType() {
        var type = $("#activeTypeValuePoc").val();
        if (type == 1) {
            $("#cavitycorrsiteOP").show();
            $("#asPDBcorrsiteOP").hide();
            $("#RescorrsiteOP").hide();
        }
        if (type == 2) {
            $("#cavitycorrsiteOP").hide();
            $("#asPDBcorrsiteOP").show();
            $("#RescorrsiteOP").hide();
        }
        if (type == 3) {
            $("#cavitycorrsiteOP").hide();
            $("#asPDBcorrsiteOP").hide();
            $("#RescorrsiteOP").show();
        }

    }

// the submit button post the computation task;
    function submitcompute() {
        $.ajax({
            type: 'Post',
            url: "processCavity_Corr.php",
            beforeSend: function () {
                $("#Corroutput").show();
            },
            success: function (data) {
                $("#Corroutput").hide();
                $("#Corroutput1").show();
                $("#outputCorr").html("");
                $("#outputCorr").html(paserMyJson(data));


            }
        });
    }

// function submitcomputeEmail(emailstr) {
//
//     $.ajax({
//         type: 'Post',
//         url: "processCavCorr_email.php",
//         data: {email: emailstr, fileid: sessionworkname},
//         beforeSend: function () {
//             //alert('Your job has been submitted. Please wait for a moment. Once the job finished, the email will reply to you immediately.');
//             document.location.reload();
//         },
//         success: function () {
//
//         }
//     });
// }
//
// function submittask() {
//     var emailstr = $("#email").val();
//     if (emailstr.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1) {
//         submitcomputeEmail(emailstr);
//     }
//     else {
//         if (emailstr == "") {
//             submitcompute();
//         }
//         else {
//             //alert("Invilid email!");
//             return false;
//         }
//     }
// }


    function selectCavityModePoc() {
        var mode = $("input[type='radio'][name='cmodePoc']:checked").val();
        // alert(mode);
        if (mode == 0) {
            $("#CligfilePoc").hide();
        }
        if (mode == 1) {
            $("#CligfilePoc").show();
        }
    }


// load the PDB file from the uploaded file;
    function loadPDBFile(sessionfile, filename) {
        var cmd = "load " + sessionfile + "/" + filename + ";select all;cartoons only;color structure; javascript readChainsInfo();";
        var cmd1 = initialScript + cmd;
        Jmol.script(myJmol, cmd1);
        $('#checkbox_showpockets').html("");
        var selected_PDB = Jmol.scriptWaitAsArray(myJmol, "select protein; write PDB")[0][0][3];
        data = {"text": selected_PDB, "filename": sessionfile + "/thischains.pdb"};
        writePDB(data);
        $('#timerapp').html("");
        $('#downloadlist').html("");
        show_main_accordion(1);
        show_main_accordion(0);

    }

// upload the protein file
    function applyAjaxFileUpload(element, phpfilename, flag) {
        var interval;
        $(element).AjaxFileUpload({
            // type: 'post',
            action: phpfilename,
            // params: {fileid: sessionworkname},
            onChange: function (filename) {
                // Create a span element to notify the user of an upload in progress
                var $span = $("<span />")
                    .attr("class", $(this).attr("id"))
                    .text("Uploading")
                    .insertAfter($(this));

                $(this).remove();

                interval = window.setInterval(function () {
                    var text = $span.text();
                    if (text.length < 13) {
                        $span.text(text + ".");
                    } else {
                        $span.text("Uploading");
                    }
                }, 200);
            },
            onSubmit: function (filename) {
            },
            onComplete: function (filename, response) {
                window.clearInterval(interval);
                var $span = $("span." + $(this).attr("id")).text(filename + " "),
                    $fileInput = $("<input />")
                        .attr({
                            type: "file",
                            name: $(this).attr("name"),
                            id: $(this).attr("id")
                        });

                if (typeof (response.error) == "string") {
                    $span.replaceWith($fileInput);

                    applyAjaxFileUpload($fileInput, phpfilename, flag);

                    alert(response.error);

                    return;
                }

                $("<a />")
                    .attr("href", "#")
                    .text("x")
                    .bind("click", function (e) {
                        $span.replaceWith($fileInput);

                        applyAjaxFileUpload($fileInput, phpfilename, flag);
                    })
                    .appendTo($span);

                if (flag == 1) {
                    sessionworkname = response.sname;

                    loadPDBFile(response.sname, filename);
                }

                if (flag == 2) {

                    $('#subcorrop').show();
                    $('#corrsiterunningshow').hide();
                    $.ajax({
                        type: "Post",
                        url: "pdb2string.php",
                        // data: {filedir: sessionfile, fileid: inputfilename},
                        success: function (response) {
                            //alert(response);
                            refreshcavitymodel = 1;
                            refreshpocketmodel = 1;
                            curmodelrecords = [];
                            Jmol.scriptWait(myJmol, "frame 1;");
                            var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";
                            var response1 = response.replace(/\n/g, "");
                            var response2 = response1.replace(/[A-Z]{3}:/g, "");
                            var response3 = response2.replace(/ /g, ",");
                            //alert(response3);
                            var cmd = initialframe + "select " + response3 + ";" + cmd_show_reside;
                            Jmol.scriptWait(myJmol, cmd);
                            $('#submitCorrsite').show();

                        }
                    });

                }


                if (flag == 3) {
                    $('#subcorrop').show();
                    $('#corrsiterunningshow').hide();
                    $.ajax({
                        type: "Post",
                        url: "txt2str2genpdb.php",
                        success: function (response) {
                            //alert(response);
                            refreshcavitymodel = 1;
                            refreshpocketmodel = 1;
                            curmodelrecords = [];
                            Jmol.scriptWait(myJmol, "frame 1");

                            var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";
                            var response1 = response.replace(/\n/g, "");
                            var cmd = initialframe + "select " + response1 + ";" + cmd_show_reside;
                            Jmol.scriptWait(myJmol, cmd);
                            var selected_ResPDB = Jmol.scriptWaitAsArray(myJmol, "select " + response1 + "; write PDB")[0][0][3];

                            //alert(selected_ResPDB);
                            var data = {"text": selected_ResPDB, "filename": sessionworkname + "/thisres2cavity.pdb"};
                            writePDB(data);
                            $.ajax({
                                type: "Post",
                                url: "txt2pdbmovefiles.php",
                                success: function (response) {
                                    $('#subcorrop').show();
                                    $('#corrsiterunningshow').hide();
                                    $('#submitCorrsite').show();
                                }

                            });


                        }
                    });
                }
            }
        });
    }

    $(function () {
        applyAjaxFileUpload("#proteinFile", "upload_pro.php", 1);
        applyAjaxFileUpload("#ligandFile", "upload_lig.php", 0);
        applyAjaxFileUpload("#ligandFilepoc", "upload_lig.php", 0);
        applyAjaxFileUpload("#activesiteFilecorrsite", "upload_cavity.php", 2);
        applyAjaxFileUpload("#activeRescorrsite", "upload_residueno.php", 3);


        function showresides(sessionfile, inputfilename) {
            $.ajax({
                type: "Post",
                url: "processRes.php",
                data: {filedir: sessionfile, fileid: inputfilename},
                success: function (response) {
                    var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";
                    var response1 = response.replace(/\n/g, "");
                    var response2 = response1.replace(/[A-Z]{3}:/g, "");
                    var response3 = response1.replace(/,/g, "\n");
                    var cmd = "select protein; color chain;select " + response2.replace(/,$/, ";") + cmd_show_reside;
                    Jmol.scriptWait(myJmol, cmd);
                }
            });
            return false;

        }

        //upload the file of residues;
        function applyAjaxFileUploadres(element) {
            var interval;
            $(element).AjaxFileUpload({
                action: "upload_resi.php",
                onChange: function (filename) {
                    var $span = $("<span />")
                        .attr("class", $(this).attr("id"))
                        .text("Uploading")
                        .insertAfter($(this));

                    $(this).remove();

                    interval = window.setInterval(function () {
                        var text = $span.text();
                        if (text.length < 13) {
                            $span.text(text + ".");
                        } else {
                            $span.text("Uploading");
                        }
                    }, 200);
                },
                onSubmit: function (filename) {
                },
                onComplete: function (filename, response) {
                    window.clearInterval(interval);
                    var $span = $("span." + $(this).attr("id")).text(filename + " "),
                        $fileInput = $("<input />")
                            .attr({
                                type: "file",
                                name: $(this).attr("name"),
                                id: $(this).attr("id")
                            });

                    if (typeof (response.error) == "string") {
                        $span.replaceWith($fileInput);

                        applyAjaxFileUploadres($fileInput);

                        //alert(response.error);

                        return;
                    }

                    $("<a />")
                        .attr("href", "#")
                        .text("x")
                        .bind("click", function (e) {
                            $span.replaceWith($fileInput);

                            applyAjaxFileUploadres($fileInput);
                        })
                        .appendTo($span);
                    showresides(response.sname, filename);

                }
            });
        }

        applyAjaxFileUploadres("#activeProteinFile");

        function showresidesSite(sessionfile, inputfilename) {
            $.ajax({
                type: "Post",
                url: "processResSite.php",
                data: {filedir: sessionfile, fileid: inputfilename},
                success: function (response) {
                    var response1 = response.replace(/\n$/g, "");
                    var selected_PDB = Jmol.scriptWaitAsArray(myJmol, "select " + response1.replace(/,$/, ";") + ";write PDB")[0][0][3];
                    var data = {"text": selected_PDB, "filename": sessionfile + "/thisresidues.pdb"};
                    $.ajax({
                        type: 'POST',
                        url: "savefile.php",
                        data: data,
                        success: function () {
                            showresides(sessionfile, "thisresidues.pdb");
                        }
                    });

                }
            });
            return false;

        }

        function applyAjaxFileUploadresSite(element) {
            var interval;
            $(element).AjaxFileUpload({
                action: "upload_resiSite.php",
                onChange: function (filename) {
                    var $span = $("<span />")
                        .attr("class", $(this).attr("id"))
                        .text("Uploading")
                        .insertAfter($(this));

                    $(this).remove();

                    interval = window.setInterval(function () {
                        var text = $span.text();
                        if (text.length < 13) {
                            $span.text(text + ".");
                        } else {
                            $span.text("Uploading");
                        }
                    }, 200);
                },
                onSubmit: function (filename) {
                },
                onComplete: function (filename, response) {
                    window.clearInterval(interval);
                    var $span = $("span." + $(this).attr("id")).text(filename + " "),
                        $fileInput = $("<input />")
                            .attr({
                                type: "file",
                                name: $(this).attr("name"),
                                id: $(this).attr("id")
                            });

                    if (typeof (response.error) == "string") {
                        $span.replaceWith($fileInput);

                        applyAjaxFileUploadresSite($fileInput);

                        //alert(response.error);

                        return;
                    }

                    $("<a />")
                        .attr("href", "#")
                        .text("x")
                        .bind("click", function (e) {
                            $span.replaceWith($fileInput);

                            applyAjaxFileUploadresSite($fileInput);
                        })
                        .appendTo($span);
                    showresidesSite(response.sname, filename);

                }
            });
        }

        applyAjaxFileUploadresSite("#activeSite");

    });

    var cavitystatus = 0;


// select user-defined chain and generate the corresponding file
    $(function () {
        $('#content').change(function () {
            var obj = document.getElementsByName("chains");
            var check_val = [];
            var cmd_selectchains = "restrict ";
            var cmd_selectchains1 = "select (";
            var selected_PDB = "";
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val.push(':' + obj[k].value);
                }
            }
            if (check_val.length != 0) {
                cmd_selectchains = cmd_selectchains + check_val.join() + ';cartoon';
                Jmol.script(myJmol, cmd_selectchains);
                cmd_selectchains1 = cmd_selectchains1 + check_val.join() + ') and hetero and (not water); write PDB';
                var selected_ligand = Jmol.scriptWaitAsArray(myJmol, cmd_selectchains1)[0][0][3];
                var tmp = get_ligandsets_html_fromPDB(selected_ligand, "Cavity_dropdown");
                var tmp1 = get_ligandsets_html_fromPDB(selected_ligand, "CavPharmer_dropdown");

                $('#curligand_content').html("");
                $('#curligand_content').html(tmp);
                $('#curligand_content_inCavPharmer').html("");
                $('#curligand_content_inCavPharmer').html(tmp1);
                $('.ui.dropdown').dropdown();


                // selected_PDB = Jmol.scriptWaitAsArray(myJmol, "write PDB")[0][0][3];
                // data = {"text": selected_PDB, "filename": sessionworkname + "/thischains.pdb"};
                // //alert(sessionworkname);
                // writePDB(data);
                // $("#subcavop").show();
            } else {
                Jmol.script(myJmol, 'restrict none; cartoon');
                var tmp = '<div class="ui mini selection dropdown" id="Cavity_dropdown"><input type="hidden" name="mylignad"><i class="dropdown icon"></i><div class="default text">None</div><div class="menu"><div class="item">None</div></div></div>';
                var tmp = '<div class="ui mini selection dropdown" id="CavPharmer_dropdown"><input type="hidden" name="mylignad"><i class="dropdown icon"></i><div class="default text">None</div><div class="menu"><div class="item">None</div></div></div>';
                $('#curligand_content').html("");
                $('#curligand_content').html(tmp);
                $('#curligand_content_inCavPharmer').html("");
                $('#curligand_content_inCavPharmer').html(tmp1);
                $('.ui.dropdown').dropdown();


            }

        });


        $('#myFormcavity').change(function () {

            Jmol.scriptWait(myJmol, "frame 1;");
            var obj = document.getElementsByName("inputCavity");
            var check_val;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = obj[k].value;
                }
            }

            //alert(check_val);
            $.ajax({
                type: 'Post',
                url: "processCavityshow.php",
                data: {fileid: sessionworkname},
                success: function (data) {
                    var json = jQuery.parseJSON(data);
                    var response = json[check_val - 1].residue;
                    Jmol.scriptWait(myJmol, initialframe + "select " + response.replace(/[A-Z]{3}:/g, "") + ";" + cmd_show_reside);
                    $('#subpocop').show();
                    $('#pocketrunningshow').hide();

                    $.ajax({
                        type: 'Post',
                        url: "movePocketfiles.php",
                        data: {id: check_val},
                        success: function (data) {
                            $('#submitPocket').show();
                        }


                    });


                }
            });


        });


        $('#myFormCorrsite').change(function () {
            // if (refreshcorrsitemodel==1){
            //     Jmol.scriptWait(myJmol,"load \""+sessionworkname+"/thischains.pdb\";cartoons only;color chain;");
            //     refreshcorrsitemodel=0;
            // }
            Jmol.scriptWait(myJmol, "frame 1;");

            var obj = document.getElementsByName("inputCavity1");
            var check_val;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = obj[k].value;
                }
            }
            var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";
            //alert(check_val);
            $.ajax({
                type: 'Post',
                url: "processCavityshow.php",
                data: {fileid: sessionworkname},
                success: function (data) {
                    refreshcavitymodel = 1;
                    refreshpocketmodel = 1;
                    var json = jQuery.parseJSON(data);
                    var response = json[check_val - 1].residue;
                    //alert(response);
                    Jmol.scriptWait(myJmol, initialframe + "select " + response.replace(/[A-Z]{3}:/g, "") + ";" + cmd_show_reside);

                    $('#subcorrop').show();
                    $('#corrsiterunningshow').hide();

                    $.ajax({
                        type: 'Post',
                        url: "moveCorrsitefiles.php",
                        data: {id: check_val},
                        success: function (data) {
                            //alert("Success to move!");
                            $('#submitCorrsite').show();
                        }


                    });


                }
            });
        });

        $('#myFormCyspred').change(function () {
            var obj = document.getElementsByName("inputCavity2");
            var check_val;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = obj[k].value;
                }
            }
            var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;";
            //alert(check_val);
            $.ajax({
                type: 'Post',
                url: "processCavityshow.php",
                data: {fileid: sessionworkname},
                success: function (data) {
                    var json = jQuery.parseJSON(data);
                    var response = json[check_val - 1].residue;
                    //alert(response);
                    Jmol.scriptWait(myJmol, "cartoons only; color chain; select " + response.replace(/[A-Z]{3}:/g, "") + ";" + cmd_show_reside);
                    refreshcavitymodel = 1;
                    refreshpocketmodel = 1;
                    refreshcorrsitemodel = 1;
                    curmodelrecords = [];
                    $('#submitCyspred').show();


                }
            });

        });

        $('#cavityresultform').change(function () {
            // if (refreshcavitymodel==1){
            //     Jmol.scriptWait(myJmol,"load \""+sessionworkname+"/thischains.pdb\";cartoons only;color chain;");
            //     refreshcavitymodel=0;
            //     countmodel=1;
            //     curmodelrecords=[];
            // }

            var obj = document.getElementsByName("cavitysurfcboxname");

            var checkarray = [];
            for (var k in obj) {
                if (obj[k].checked) {
                    checkarray.push(obj[k].value);
                }
            }

            // alert(checkarray);
            // countmodel=1

            var cmd = initialframe + "frame [1";
            $(checkarray).each(function (index, value) {
                if (value) {
                    // if(!curmodelrecords[value]) {
                    //     countmodel++;
                    //     curmodelrecords[value] = countmodel;
                    //     var tempstr = sessionworkname + "/example/AA/thischains_surface_" + value + ".pdb";
                    //     var addsurfcmd = 'load append \"' + tempstr + '\";select {'+countmodel+'.1}; wireframe 0.3; color {' + countmodel + '.1} \"' + colornames[value-1] + '\";';
                    //     Jmol.scriptWait(myJmol, addsurfcmd);
                    //     // alert(addsurfcmd);

                    // }
                    cmd += ",";
                    value++;
                    cmd += value;

                }
            });
            // alert(cmd);

            Jmol.scriptWait(myJmol, cmd + "];");

        });


        function addrow(table_id, row_data, jsondata, i) {
            // alert(jsondata[i-1].residue);

            var table = document.getElementById(table_id);
            var row = table.insertRow(i);

            var cell0 = row.insertCell(0);
            cell0.innerHTML = "<td>" + i + "</td>";

            var cell1 = row.insertCell(1);
            cell1.innerHTML = "<td>" + row_data[0] + "</td>";

            var cell2 = row.insertCell(2);
            cell2.innerHTML = "<td>" + row_data[1] + "</td>";

            var cell3 = row.insertCell(3);
            cell3.innerHTML = "<td>" + row_data[2] + "</td>";

            var cell4 = row.insertCell(4);

            if (row_data[3].equals("Amphibious")) {
                row_data[3] = "less druggable";
            }

            cell4.innerHTML = "<td>" + row_data[3] + "</td>";

            var cell5 = row.insertCell(5);
            cell5.innerHTML = '<td><input type="checkbox" name="cavitysurfcboxname" value="' + i + '" /></td>';

            var cell6 = row.insertCell(6);
            // alert(jsondata[i-1].residue);
            // var reshtml='<div class="ui mini button" id="pop'+i+'">More</div><div class="ui flowing popup top left transition hidden"><div class="ui two column divided center aligned grid"><div class="column">'+jsondata[i-1].residue+'</div></div></div>';
            var reshtml = '<div id="popbtn' + i + '" style="color:blue;" data-title="" data-content=""><u><b>More</b></u></div>';

            cell6.innerHTML = "<td>" + reshtml + "</td>";


        }

        function parseJsoncavity(jsondata, radioname) {
            var json = jsondata;
            var formhtml = '<div class="ui three column grid">';
            for (var i = 1; i <= json; i++) {
                var tmphtml = '<div class="column"><input type="radio" name=' + radioname + ' value="' + i + '"><label>Cavity' + i + '</label></div>';
                formhtml = formhtml + tmphtml;
            }
            formhtml = formhtml + '</div>';
            return formhtml;
        }


        function submitTask(phpfilename, mydata) {

            $.ajax({
                type: 'Post',
                url: phpfilename,
                data: mydata,
                timeout: 10800000,
                beforeSend: function () {
                    $('#cavityrunningshow').show();

                },
                success: function (data) {
                    // alert(data);
                    // clearInterval(timer);
                    cavitystatus = 1;
                    if (data > 0) {
                        $('.ui.accordion').accordion({exclusive: false});
                        $('#cavitytitle').removeClass('active');
                        $('#cavitycont').removeClass('active');

                        $('#pockettitle').addClass('active');
                        $('#pocketcont').addClass('active');

                        $('#corrsitetitle').addClass('active');
                        $('#corrsitecont').addClass('active');

                        $('#cyspredtitle').addClass('active');
                        $('#cyspredcont').addClass('active');


                        $('#cavityrunningshow').hide();
                        $('#myFormcavity').show();
                        $('#myFormCorrsite').show();
                        $('#subcysop').show();
                        $('#submitCyspred').show();

                        $('#cyspredrunningshow').hide();

                        //shown in CavPharmer submission;
                        $("#Cavityoutput").html("");
                        $("#Cavityoutput").html(parseJsoncavity(data, "inputCavity"));
                        //shown in Corrsite submission;
                        $("#CavityoutputInCS").html("");
                        $("#CavityoutputInCS").html(parseJsoncavity(data, "inputCavity1"));

                        // $("#CavityoutputInCYS").html("");
                        // $("#CavityoutputInCYS").html(parseJsoncavity(data, "inputCavity2"));
                        $('#downloadop').show();
                        $('#downloadlist').html('<div class="ui checkbox"> <input checked="checked" type="checkbox"  name="mydownload" value="downcavity"><label> Cavity results</label> </div><br>')

                        var jobid = sessionworkname;
                        var myjson;
                        $.ajax({
                            type: 'Post',
                            url: "processCavityshow.php",
                            data: {fileid: sessionworkname},
                            async: false,
                            success: function (data) {
                                myjson = jQuery.parseJSON(data);
                            }
                        });
                        // alert(myjson[0].residue);

                        pocketsubmitorder = Array();
                        $("#resultTable  tr:not(:first)").empty("");

                        $.ajax({
                            url: 'deal_result.php', // point to server-side PHP script
                            data: {'jobid': jobid},
                            type: 'POST',
                            async: false,
                            success: function (php_response) {

                                var obj = $.parseJSON(php_response);
                                var index = 0;
                                for (var key1 in obj) {
                                    var result = new Array();
                                    for (var key2 in obj[key1]) {
                                        result.push(obj[key1][key2]);
                                    }
                                    addrow("resultTable", result, myjson, index + 1);
                                    index++;
                                }
                                $('#entry3').show();
                                $('#cavity_noresults').hide();
                                $("#resultTable").tablesorter();
                                for (i = 1; i <= myjson.length; i++) {
                                    var element = '#popbtn' + i;
                                    $(element).popup({on: 'click', position: 'right center'});
                                    $(element).attr('data-content', myjson[i - 1].residue.replace(/\,/g, ", "));
                                }

                                $('#CavityResulttilte').addClass('active');
                                $('#CavityResultcont').addClass('active');

                                Jmol.scriptWait(myJmol, "load \"" + sessionworkname + "/thischains_A.pdb\";cartoons only;color chain;");

                                var obj = document.getElementsByName("cavitysurfcboxname");
                                var checkarray = [];
                                for (var k in obj) {
                                    checkarray.push(obj[k].value);
                                }

                                countmodel = 1;
                                cmd = "";
                                $(checkarray).each(function (index, value) {
                                    if (value) {
                                        countmodel++;
                                        var tempstr = sessionworkname + "/example/AA/thischains_surface_" + value + ".pdb";
                                        var addsurfcmd = 'load append \"' + tempstr + '\";select {' + countmodel + '.1}; wireframe 0.5; color {' + countmodel + '.1} \"' + colornames[value - 1] + '\";';
                                        cmd += ",";
                                        cmd += countmodel;
                                        Jmol.scriptWait(myJmol, addsurfcmd);
                                    }
                                });

                                Jmol.scriptWait(myJmol, 'frame 1;');

                            }
                        });


                    } else {
                        $('#cavityrunningshow').hide();
                        alert("Fail to run Cavity. \n The coordinate of the ligand file may not be located in the binding site of the current protein.Please check it!");
                        $('#CavityResulttilte').addClass('active');
                        $('#CavityResultcont').addClass('active');
                        $('#entry3').hide();
                        $('#cavity_noresults').show();
                        $('#cavity_noresults').html("No cavities to be detected.");
                    }
                }

            });

            return false;
        }

        function check_molfile_php() {
            // check the file of theligand.mol2;
            // var flag=0;
            $.ajax({
                type: 'POST',
                url: "check_molfile.php",
                success: function (response) {
                    // alert(response);
                    if (response) {
                        $('#cavityrunningshow').hide();
                        alert("The file of ligand has not been detected. Please confirm it.");
                    } else {
                        // return 1;
                    }
                }
            });
        }

        $('#checkcavitybar').click(function (e) {
            e.preventDefault();
            var txtfilename = sessionworkname + "/example/AA/outputcavity.txt";
            $.ajax({
                url: txtfilename,
                type: 'HEAD',
                error: function () {
                    // alert("The job has not been finished yet.");
                },
                success: function () {
                    e.preventDefault();
                    cavitystatus = 1;
                    $.ajax({
                        type: 'POST',
                        url: "get_cavitynum.php",
                        success: function (data) {
                            // alert(data);
                            if (data > 0) {
                                $('.ui.accordion').accordion({exclusive: false});
                                $('#cavitytitle').removeClass('active');
                                $('#cavitycont').removeClass('active');

                                $('#pockettitle').addClass('active');
                                $('#pocketcont').addClass('active');

                                $('#corrsitetitle').addClass('active');
                                $('#corrsitecont').addClass('active');

                                $('#cyspredtitle').addClass('active');
                                $('#cyspredcont').addClass('active');


                                $('#cavityrunningshow').hide();
                                $('#myFormcavity').show();
                                $('#myFormCorrsite').show();
                                $('#subcysop').show();
                                $('#cyspredrunningshow').hide();


                                $("#Cavityoutput").html("");
                                $("#Cavityoutput").html(parseJsoncavity(data, "inputCavity"));

                                $("#CavityoutputInCS").html("");
                                $("#CavityoutputInCS").html(parseJsoncavity(data, "inputCavity1"));
                                // $("#CavityoutputInCYS").html("");
                                // $("#CavityoutputInCYS").html(parseJsoncavity(data, "inputCavity2"));
                                $('#downloadop').show();
                                $('#downloadlist').html('<div class="ui checkbox"> <input checked="checked" type="checkbox"  name="mydownload" value="downcavity"><label> Cavity results</label> </div><br>')

                                var jobid = sessionworkname;
                                var myjson;
                                $.ajax({
                                    type: 'Post',
                                    url: "processCavityshow.php",
                                    data: {fileid: sessionworkname},
                                    async: false,
                                    success: function (data) {
                                        myjson = jQuery.parseJSON(data);


                                    }
                                });
                                // alert(myjson[0].residue);

                                pocketsubmitorder = Array();
                                $("#resultTable  tr:not(:first)").empty("");

                                $.ajax({
                                    url: 'deal_result.php', // point to server-side PHP script
                                    data: {'jobid': jobid},
                                    type: 'POST',
                                    async: false,
                                    success: function (php_response) {

                                        var obj = $.parseJSON(php_response);
                                        var index = 0;
                                        for (var key1 in obj) {
                                            var result = new Array();
                                            for (var key2 in obj[key1]) {
                                                result.push(obj[key1][key2]);
                                            }
                                            addrow("resultTable", result, myjson, index + 1);
                                            index++;
                                        }
                                        $('#entry3').show();
                                        $("#resultTable").tablesorter();
                                        for (i = 1; i <= myjson.length; i++) {
                                            var element = '#popbtn' + i;
                                            $(element).popup({on: 'click', position: 'right center'});
                                            $(element).attr('data-content', myjson[i - 1].residue.replace(/\,/g, ", "));
                                        }

                                        $('#CavityResulttilte').addClass('active');
                                        $('#CavityResultcont').addClass('active');

                                        Jmol.scriptWait(myJmol, "load \"" + sessionworkname + "/thischains_A.pdb\";cartoons only;color chain;");

                                        var obj = document.getElementsByName("cavitysurfcboxname");
                                        var checkarray = [];
                                        for (var k in obj) {
                                            checkarray.push(obj[k].value);
                                        }

                                        countmodel = 1;
                                        cmd = "";
                                        $(checkarray).each(function (index, value) {
                                            if (value) {
                                                countmodel++;
                                                var tempstr = sessionworkname + "/example/AA/thischains_surface_" + value + ".pdb";
                                                var addsurfcmd = 'load append \"' + tempstr + '\";select {' + countmodel + '.1}; wireframe 0.5; color {' + countmodel + '.1} \"' + colornames[value - 1] + '\";';
                                                cmd += ",";
                                                cmd += countmodel;
                                                Jmol.scriptWait(myJmol, addsurfcmd);
                                            }
                                        });

                                        Jmol.scriptWait(myJmol, 'frame 1;');

                                    }
                                });


                            } else {
                                $('#cavityrunningshow').hide();
                                alert("Fail to run Cavity. \n The coordinate of the ligand file may not be located in the binding site of the current protein.Please check it!");

                            }


                        }

                    });
                }

            });
        });


        $('#submitCavity').click(function (e) {
            e.preventDefault();

            $('#cavityrunningshow').first().show();
            $('#timerapp').html("Calculating running time...");

            setTimeout(function () {

                // get the selected chains;
                var obj = document.getElementsByName("chains");
                var check_val = [];
                var cmd_selectchains = "select (";
                // var cmd_selectchains1 = "select ";
                // var selected_PDB = "";
                for (var k in obj) {
                    if (obj[k].checked) {
                        check_val.push(':' + obj[k].value);
                    }
                }
                // alert(check_val);
                // get the dropdown ligand;

                // make sure the selected chains to generate;
                var dataPro;
                if (check_val.length != 0) {
                    $('#cavityrunningshow').show();
                    // generate the selected PDB

                    var selected_PDB = Jmol.scriptWaitAsArray(myJmol, "select (" + check_val.join() + ") and protein; write PDB")[0][0][3];
                    dataPro = {"text": selected_PDB, "filename": sessionworkname + "/thischains.pdb"};
                    var residuenum = writePDB(dataPro);
                    residuenum = Math.pow(residuenum, 2) * 0.00003 - 0.0086 * residuenum + 9;
                    // alert(residuenum);
                    $('#timerapp').html("");
                    $('#timerapp').html("The roughly estimated computational time is " + residuenum.toFixed(0) + " minutes. Please be patient.");

                    var selected_PDB1 = Jmol.scriptWaitAsArray(myJmol, "select (" + check_val.join() + "); write PDB")[0][0][3];
                    dataPro1 = {"text": selected_PDB1, "filename": sessionworkname + "/thischains_A.pdb"};
                    writePDB(dataPro1);

                    // cmd_selectchains = cmd_selectchains + check_val.join() + ');write PDB';
                    // Jmol.script(myJmol, cmd_selectchains);

                    // check the current mode in Cavity;
                    var mode = $("input[type='radio'][name='cmode']:checked").val();
                    var dp_cavity = $('#Cavity_dropdown').dropdown('get value');
                    // var input = $("#ligandFile").val().length();
                    // alert("ligandFile: "+input);
                    if (mode == 1) {
                        if (dp_cavity.length >= 1) {
                            var cmd_selectchains1 = "select [" + dp_cavity.substring(0, dp_cavity.length - 1) + "]:" + dp_cavity.substring(dp_cavity.length - 1) + '; write PDB';
                            // alert(cmd_selectchains1);
                            // generate the ligand file (*.mol2 with obabel)
                            var selected_ligand = Jmol.scriptWaitAsArray(myJmol, cmd_selectchains1)[0][0][3];
                            data1 = {"text": selected_ligand, "filename": sessionworkname + "/thisligand.pdb"};
                            writePDB(data1);
                        } else {
                            check_molfile_php();
                        }
                    }


                    cavitystatus = 0;
                    var interval = setInterval(function () {
                        if (cavitystatus > 0) {
                            clearInterval(interval);
                        } else {
                            $('#checkcavitybar').trigger('click');
                        }
                    }, 300000);

                    var chainfilename = sessionworkname + "/" + "thischains.pdb";
                    // alert(chainfilename);
                    $("input.group1").attr("disabled", true);
                    $.ajax({
                        url: chainfilename,
                        type: 'HEAD',
                        // beforeSend: function () {
                        //    writePDB(dataPro);
                        // },
                        error: function () {
                            $('#cavityrunningshow').hide();
                            alert("The protein has not been loaded! please upload again.");
                        },
                        success: function () {
                            e.preventDefault();
                            $('#cavityrunningshow').show();
                            submitTask("cavity.php", $('#cavityForm').serialize());
                            // $("input.group1").attr("disabled", true);
                            $("input.group1").attr("disabled", false);
                        }
                    });


                } else {
                    $('#cavityrunningshow').hide();
                    alert("The protein has not been loaded. Please upload again.");
                }

            }, 100);


        });


        $('#submitPocket').click(function (e) {
            e.preventDefault();
            var obj = document.getElementsByName("inputCavity");
            var check_val;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = obj[k].value;
                }
            }
            // // check the current mode in Cavity;
            var mode = $("input[type='radio'][name='cmodePoc']:checked").val();
            var dp_cavity = $('#CavPharmer_dropdown').dropdown('get value');
            // var input = $("#ligandFile").val().length();
            // alert("ligandFile: "+input);
            if (mode == 1) {
                if (dp_cavity.length >= 1) {
                    var cmd_selectchains1 = "select [" + dp_cavity.substring(0, dp_cavity.length - 1) + "]:" + dp_cavity.substring(dp_cavity.length - 1) + '; write PDB';
                    // alert(cmd_selectchains1);
                    // generate the ligand file (*.mol2 with obabel)
                    var selected_ligand = Jmol.scriptWaitAsArray(myJmol, cmd_selectchains1)[0][0][3];
                    data1 = {"text": selected_ligand, "filename": sessionworkname + "/thisligand.pdb"};
                    writePDB(data1);
                    // $.when(writePDB(data1)).then(submitCavPharmertask());
                    var chainfilename = sessionworkname + "/" + "thisligand.mol2";
                    // alert(chainfilename);
                    // $("input.group1").attr("disabled", true);
                    $.ajax({
                        url: chainfilename,
                        type: 'HEAD',
                        error: function () {
                            alert("The ligand has not been detected! please make sure.");
                        },
                        success: function () {
                            e.preventDefault();
                            submitCavPharmertask();
                            // $('#pocketrunningshow').hide();
                        }
                    });

                } else {
                    $.ajax({
                        type: 'POST',
                        url: "check_molfile.php",
                        success: function (response) {
                            // alert(response);
                            if (response) {
                                alert("The file of ligand has not been detected. Please confirm it.");
                            } else {
                                submitCavPharmertask();
                            }
                        }
                    });
                }
            } else {
                submitCavPharmertask();
            }

            //alert(check_val);

            function generatePharmaTable(mycheckval) {
                var tablediv = '<table class="table" id="pocketTable" style="text-align: left" ><thead> <tr><th>Pharmacophore class of <b>Cavity' + mycheckval + '</b></th><th>x</th><th>y</th><th>z</th><th>Radius(Å)</th></tr></thead><tbody> ';
                $.ajax({
                    type: 'Post',
                    url: "generateTable.php",
                    data: {'filenamedir': sessionworkname, 'cavid': mycheckval},
                    async: false,
                    success: function (response) {
                        tablediv += response;
                        tablediv += ' </tbody> </table>';
                    }
                });
                // alert(tablediv);
                return tablediv;
            }

            function click_show_pharma_tabel(element, mycheckval) {
                $(element).click(function () {
                    var tablehtml = generatePharmaTable(mycheckval);
                    // alert(tablehtml);
                    $('#show_pharma_table').html("");
                    $('#show_pharma_table').html(tablehtml);
                    // $('.ui.celled.table').tablesort();
                    $('#pocketTable').tablesorter();

                });
            }


            function submitCavPharmertask() {
                $.ajax({
                    type: 'Post',
                    url: "pocket.php",
                    data: $('#pocketForm').serialize() + '&' + $.param({"cavid": check_val}),
                    beforeSend: function () {
                        $('#pocketrunningshow').show();
                    },
                    success: function (jsondata) {

                        $.ajax({
                            type: 'Post',
                            url: "processpkoutatoms.php",
                            data: {"cavid": check_val},
                            dataType: 'json',
                            success: function (response) {

                                countmodel++;
                                var curindex = countmodel;

                                // var colorcmd="select POK and *.n; spacefill; color blue; select POK and *.o; spacefill; color red; select {"+curindex+".1} and POK and *.c; spacefill; color lawngreen; select POK and *.f; spacefill; color cyan; select POK and *.h; spacefill; color lightblue; select POK and *.s; spacefill; color gold;";

                                var colorcmd = "select {" + curindex + ".1} and POK and *.n; spacefill; color translucent 4 blue; select {" + curindex + ".1} and POK and *.o; spacefill; color translucent 4 red; select {" + curindex + ".1} and POK and *.c; spacefill; color lawngreen; select {" + curindex + ".1} and POK and *.f; spacefill; color translucent 4 cyan; select {" + curindex + ".1} and POK and *.h; spacefill; color lightblue; select {" + curindex + ".1} and POK and *.s; spacefill; color gold;  isosurface surf" + curindex + " select({" + curindex + ".1} and POK and *.b) solvent; color $surf" + curindex + " white; "


                                var addpocketcmd = initialframe + 'load append \"' + sessionworkname + "/Pocket_on_cavity" + check_val + "/pkout-pharmacophore-free.pdb" + '\";' + colorcmd;
                                var arrowcmd = "";
                                for (var i = 0; i < response[0].length; i++) {
                                    // arrowcmd += response[0][i].atom;
                                    // arrowcmd += response[1][i].atom;
                                    var atom_start = "";
                                    var atom_end = "";
                                    var curArrow = "arrow" + curindex + i;
                                    if (response[1][i].label.equals("N")) {
                                        atom_start = "{" + curindex + ".1} and " + response[0][i].atom;
                                        atom_end = "{" + curindex + ".1} and " + response[1][i].atom;
                                    }
                                    if (response[1][i].label.equals("O")) {
                                        atom_start = "{" + curindex + ".1} and " + response[1][i].atom;
                                        atom_end = "{" + curindex + ".1} and " + response[0][i].atom;
                                    }
                                    arrowcmd += "draw " + curArrow + " diameter 0.4 arrow (" + atom_end + ") (" + atom_start + "); color $" + curArrow + " black;";
                                }

                                var curcmd = addpocketcmd + arrowcmd + 'frame [1,' + curindex + '];';

                                // addpocketcmd +='frame [1,'+curindex+'];';
                                Jmol.scriptWait(myJmol, curcmd);
                                $('#pocketrunningshow').hide();
                                var showhtmldiv = '<div class="ui checkbox"> <input type="checkbox" checked="checked" name="mypocketoutputs" value="' + curindex + '"><label id="more_cavpharmer_' + check_val + '"> <u><b>Cavity' + check_val + ' pharmacophores</b></u></label></div>&nbsp; &nbsp;&nbsp; &nbsp;';
                                // showhtmldiv +='<div id="more_poc'+check_val+'" style="color:blue;" data-title="" data-content=""><u><b>More</b></u></div>';
                                $('#checkbox_showpockets').append(showhtmldiv);
                                // $('label').popup({on: 'click', position: 'bottom left'});
                                // var tablehtml1='<table class="ui small celled table" style="width: 200%"> <tr><th>Pharmacophore Class</th><th>x</th><th>y</th><th>z</th><th>Radius(A)</th></tr> <tr><td>H-bond acceptor center</td><td>43.000</td><td>25.000</td><td>33.500</td><td>1</td></tr> <tr><td>H-bond root</td><td>45.189</td><td>23.698</td><td>32.367</td><td>1.5</td></tr> <tr><td>H-bond acceptor center</td><td>44.000</td><td>35.000</td><td>36.500</td><td>1</td></tr> <tr><td>H-bond root</td><td>45.448</td><td>37.299</td><td>35.862</td><td>1.5</td></tr> <tr><td>Hydrophobic center</td><td>48.000</td><td>30.000</td><td>35.000</td><td>1.5</td></tr> <tr><td>H-bond donor center</td><td>49.500</td><td>26.500</td><td>34.500</td><td>1</td></tr> </table>';
                                var tablehtml = generatePharmaTable(check_val);
                                // alert(tablehtml);


                                $('#show_pharma_table').html(tablehtml);
                                // $('.ui.celled.table').tablesort();
                                $('#pocketTable').tablesorter();

                                // $('#more_cavpharmer_'+check_val).html(tablehtml);
                                click_show_pharma_tabel('#more_cavpharmer_' + check_val, check_val);


                                $('#downloadlist').append('<div class="ui checkbox"> <input type="checkbox" checked="checked" name="mydownload" value="downpocketcavity' + check_val + '"><label> CavPharmer results on Cavity' + check_val + '</label> </div><br>');

                                $('#CavityResulttilte').removeClass('active');
                                $('#CavityResultcont').removeClass('active');
                                $('#PocketResulttilte').addClass('active');
                                $('#PocketResultcont').addClass('active');

                                $('#CorrsiteResulttitle').removeClass('active');
                                $('#CorrsiteResultcont').removeClass('active');
                                $('#CyspredResulttitle').removeClass('active');
                                $('#CyspredResultcont').removeClass('active');


                                $('#entrypocket').show();


                            }

                        });

                    }
                });
            }


        });


        $('#checkbox_showpockets').change(function () {
            var obj = document.getElementsByName("mypocketoutputs");
            var check_val = [];
            // var cmd_selectchains = "restrict ";
            // var selected_PDB = "";
            var cmd = initialframe + "frame [1";
            for (var k in obj) {
                if (obj[k].checked) {
                    cmd += ",";
                    cmd += obj[k].value;
                }
            }
            cmd += "];"
            Jmol.scriptWait(myJmol, cmd);

        });


        function addrow_csv(table_id, row_data, i) {
            var table = document.getElementById(table_id);
            var row = table.insertRow(i);

            var cell0 = row.insertCell(0);
            cell0.innerHTML = "<td>" + row_data[0] + "</td>";

            var cell1 = row.insertCell(1);
            cell1.innerHTML = "<td>" + row_data[1] + "</td>";

            var cell2 = row.insertCell(2);
            cell2.innerHTML = "<td>" + row_data[2] + "</td>";

            var cell3 = row.insertCell(3);
            cell3.innerHTML = "<td>" + row_data[3] + "</td>";

            var cell4 = row.insertCell(4);
            cell4.innerHTML = "<td>" + row_data[4] + "</td>";

            var cell5 = row.insertCell(5);
            cell5.innerHTML = "<td>" + row_data[5] + "</td>";

            var cell6 = row.insertCell(6);
            cell6.innerHTML = "<td>" + row_data[6] + "</td>";

            var cell7 = row.insertCell(7);


            // Jmol.scriptWait(myJmol, "select "+resid+ ";wireframe 0.5; spacefill 0.3; color cpk;");
            // alert(resid);
            var cmd = "";
            if (row_data[1].equals("None")) {
                // var tempstr = sessionworkname + "/example/AA/thischains.pdb";
                // covcyscountmodel++;
                // cmd= 'load append \"'+tempstr+'\"; cartoons only; color chain;';

            } else {
                var resid = row_data[0].replace("CYS_", "");
                var residarr = resid.split("_");
                resid = residarr[1] + ":" + residarr[0];
                cell7.innerHTML = '<td><input type="radio" name="csvtablecbox" value="' + (i - 1) + '"/></td>';

                var cavid = row_data[1].replace("cavity_", "");

                cavid++;
                // cyscovshowlist.push("frame 1;"+initialframe+"select "+resid+";frame [1"+(cavid+1)+"];");
                // var tempstr = sessionworkname + "/example/AA/thischains_surface_" + cavid + ".pdb";
                // covcyscountmodel++;
                // cmd= 'load append \"'+tempstr+'\"; color {' + covcyscountmodel + '.1} \"' + colornames[cavid] + '\";';
                cmd = initialframe + "frame 1;select " + resid + ";wireframe 0.9; spacefill 0.2;color cpk; frame [1," + cavid + "];";
                cyscovshowlist.push(cmd);
                // // alert(cmd);
                // // covcysframemap[i]= covcyscountmodel;

                // Jmol.scriptWait(myJmol, cmd);
            }


        }


        $('#submitCyspred').click(function (e) {

            covcyscountmodel = 1;
            covcysframemap = [];
            covcysresmap = [];
            cyscovshowlist = [];
            e.preventDefault();
            Jmol.scriptWait(myJmol, "frame 1;" + initialframe);

            $.ajax({
                type: 'Post',
                url: "covcyspred.php",
                beforeSend: function () {
                    $('#cyspredrunningshow').show();
                },
                success: function (php_response) {

                    //alert(php_response);
                    $('#cyspredrunningshow').hide();
                    $('#CavityResulttilte').removeClass('active');
                    $('#CavityResultcont').removeClass('active');

                    $('#PocketResulttilte').removeClass('active');
                    $('#PocketResultcont').removeClass('active');

                    $('#CorrsiteResulttitle').removeClass('active');
                    $('#CorrsiteResultcont').removeClass('active');
                    $('#CyspredResulttitle').addClass('active');
                    $('#CyspredResultcont').addClass('active');
                    var obj = $.parseJSON(php_response);
                    // alert(obj);
                    if (obj.length == 0) {
                        $('#entry4').hide();
                        $('#cyspred_noresults').html("");
                        $('#cyspred_noresults').html("No Cys to be detected.");
                    } else {

                        $('#downloadlist').append('<div class="ui checkbox"> <input type="checkbox" checked="checked" name="mydownload" value="downcovcys"><label> CovCys results</label> </div><br>');


                        var index = 0;
                        $("#csv_table  tr:not(:first)").empty("");
                        for (var key1 in obj) {
                            var result = new Array();
                            for (var key2 in obj[key1]) {
                                result.push(obj[key1][key2]);
                            }
                            if (typeof (result[0]) !== "undefined") {
                                addrow_csv("csv_table", result, index + 1);
                                index++;
                            }
                        }
                        Jmol.scriptWait(myJmol, "frame 1");
                        $('#entry4').show();
                        $("#csv_table").tablesorter();
                        $('#cyspred_noresults').html("");

                    }


                }
            });
        });


        $('#corrsiteResultForm').change(function () {
            var obj = document.getElementsByName("inputRes");
            var check_val;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = obj[k].value;
                }
            }
//                var cmd_show_reside = "wireframe 0.5; spacefill 0.3; color cpk;"

            // var cmdsurface0 = "isoSurface off;isoSurface surf0 on; color $surf0 translucent 2 violet;";
            // var cmdsurface1 = "isoSurface " + tmpsurf + " on; color $" + tmpsurf + " translucent 1 violet";
            Jmol.scriptWait(myJmol, "frame [1," + check_val + "];");


        });

        $('#covcysresultform').change(function () {
            var obj = document.getElementsByName("csvtablecbox");

            var checkarray = "";
            for (var k in obj) {
                if (obj[k].checked) {
                    checkarray = obj[k].value;
                }
            }

            // alert(cyscovshowlist[checkarray]);
            // Jmol.scriptWait(myJmol, rescmd +"wireframe 0.5; spacefill 0.3; color cpk;");
            Jmol.scriptWait(myJmol, cyscovshowlist[checkarray]);


        });

        function refreshcorrsitFrames() {

            var orthobj = document.getElementsByName("selectOrthosite");
            // alert("Hello aaaaaa!");
            var alloobj = document.getElementsByName("corrframeout");
            // alert("Hello aaaaaa!");


            var check_val_orth = "";
            var check_val_allo = [];

            for (var k in orthobj) {
                if (orthobj[k].checked) {
                    check_val_orth = orthobj[k].value;
                }
            }
            // alert(check_val_orth);

            var curindex = check_val_orth - 1;
            var foucusresstr = corrsiteorthores[curindex];


            Jmol.scriptWait(myJmol, "frame 1;" + initialframe + "select " + foucusresstr + ";" + cmd_show_reside);

            var tmpcmd = "frame [1";
            for (var k in alloobj) {
                if (alloobj[k].checked) {
                    var curnum = alloobj[k].value.split("-");
                    if (curnum[0] == check_val_orth) {
                        tmpcmd += ",";
                        tmpcmd += curnum[1];
                    }
                }
            }
            tmpcmd += "];"

            Jmol.scriptWait(myJmol, tmpcmd);

        }

        $('#corrResultTable').change(function () {
            refreshcorrsitFrames();


        });


        function addrow_corrsite(jsondata) {

            var json = jQuery.parseJSON(jsondata);

            corrsitelistnum++;
            var tempcell1 = "";


            if (json[0].score == "Cavity-1") {
                tempcell1 = '<tr><td><div class="row"><input type="radio" name="selectOrthosite" checked="checked" value="' + corrsitelistnum + '"><label>Custom pocket</label></div></td>';
            } else if (json[0].score == "Cavity-2") {
                tempcell1 = '<tr><td><div class="row"><input type="radio" name="selectOrthosite" checked="checked" value="' + corrsitelistnum + '"><label>Custom residue</label></div></td>';
            } else {
                tempcell1 = '<tr><td><div class="row"><input type="radio" name="selectOrthosite" checked="checked" value="' + corrsitelistnum + '"><label>' + json[0].score + '</label></div></td>';

            }
            corrsiteorthores.push(json[0].residues.replace(/[A-Z]{3}:/g, ""));


            var tempcell2 = '<td>';
            var tmphtml = "";
            for (var i = 1; i < json.length; i++) {
                cavitynum = json[i].cavity.replace("Cavity", "");
                cavitynum++;
                var tempnum = corrsitelistnum + "-" + cavitynum;
                if (json[i].score > 0.5) {
                    tmphtml = '<input type="checkbox" name="corrframeout" checked="checked" value="' + tempnum + '"><label style="color:violet">' + json[i].cavity + ": " + json[i].score + '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                } else {
                    tmphtml = '<input type="checkbox" name="corrframeout" value="' + tempnum + '"><label>' + json[i].cavity + ": " + json[i].score + '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                tempcell2 = tempcell2 + tmphtml;
            }
            tempcell2 = tempcell2 + "</td></tr>";
            $('#corrResultTable').append(tempcell1 + tempcell2);
            refreshcorrsitFrames();
        }


        // parse the php-returned data and generate the radio form;
        function paserMyJson(jsondata) {
            var json = jQuery.parseJSON(jsondata);

            var modelnum = 1;
            var formhtml = 'Orthosite: <input type="checkbox"  name="inputorthosite" checked="checked" value="0"><label style="color:violet">' + json[0].cavity + '</label><p></p><p>Allosite:</p><div class="ui four column grid">';
            var rescmd = "define temp " + json[0].residues.replace(/[A-Z]{3}:/g, "") + "; select temp; wireframe 0.5; color cpk;";
            Jmol.scriptWait(myJmol, rescmd);
            for (var i = 1; i < json.length; i++) {
                i1 = i + 1;
                if (json[i].score > 0.5) {
                    var tmphtml = '<div class="column"><input type="radio" name="inputRes" value="' + i1 + '"><label style="color:violet">' + json[i].cavity + ": " + json[i].score + '</label></div>';
                    formhtml = formhtml + tmphtml;
                } else {
                    var tmphtml = '<div class="column"><input type="radio" name="inputRes" value="' + i1 + '"><label>' + json[i].cavity + ": " + json[i].score + '</label></div>';
                    formhtml = formhtml + tmphtml;
                }
                cavitynum = json[i].cavity.replace("Cavity", "");
                modelnum++;
                var tempstr = sessionworkname + "/example/AA/thischains_surface_" + cavitynum + ".pdb";
                var addsurfcmd = 'load append \"' + tempstr + '\";color {' + modelnum + '.1} \"' + colornames[cavitynum] + '\";';
                Jmol.scriptWait(myJmol, addsurfcmd);
            }

            formhtml = formhtml + '</div><p></p><p>*Note: Cavity(id):(Z-Score). When Z-score > 0.5, this cavity may be a potential site. </p>';
            Jmol.scriptWait(myJmol, "frame 1;");
            return formhtml;
        }


        $('#submitCorrsite').click(function (e) {
            e.preventDefault();

            var obj = document.getElementsByName("inputCavity1");
            var check_val = 0;
            for (var k in obj) {
                if (obj[k].checked) {
                    check_val = 1;
                }
            }

            if (check_val == 0) {

                alert("Please choose or upload one orthosetric site.");

            } else {
                $.ajax({
                    type: 'Post',
                    url: "corrsite.php",
                    beforeSend: function () {
                        $('#corrsiterunningshow').show();
                    },
                    success: function (data) {
                        //alert(data);
                        // var pocketcmd='load APPEND pkout.pdb;Spacefill; frame *;display 1.1,2.1';
                        // Jmol.scriptWait(myJmol, pocketcmd);
                        $('#CavityResulttilte').removeClass('active');
                        $('#CavityResultcont').removeClass('active');

                        $('#PocketResulttilte').removeClass('active');
                        $('#PocketResultcont').removeClass('active');

                        $('#CyspredResulttitle').removeClass('active');
                        $('#CyspredResultcont').removeClass('active');

                        $('#CorrsiteResulttitle').addClass('active');
                        $('#CorrsiteResultcont').addClass('active');

                        // $("#corrsiteResultDiv").html("");
                        $('#corrsiterunningshow').show();

                        var json1 = jQuery.parseJSON(data);
                        if (json1.length <= 1) {
                            $('#corrsiteResultForm').hide();
                            $('#corrsite_noresults').html("");
                            $('#corrsite_noresults').html("No allosteric sites to be detected.");
                            $('#corrsiterunningshow').hide();

                        } else {
                            $('#corrsite_noresults').html("");
                            $('#corrsiteResultForm').show();
                            addrow_corrsite(data);
                            $('#corrsiterunningshow').hide();

                            $.ajax({
                                type: 'Post',
                                url: "renamecorrsiteout.php",
                                data: {'cavityname': json1[0].score},
                                success: function (data) {
                                    // alert("Success!");

                                }
                            });
                        }


                        $('#downloadlist').append('<div class="ui checkbox"> <input type="checkbox" checked="checked" name="mydownload" value="downcorrsite' + json1[0].score + '"><label> CorrSite results on  ' + json1[0].score + '</label> </div><br>')
                        // $('#corrsitesurfshow').show();
                        // setTimeout(function() {
                        //     $("#corrsiteResultDiv").html("");
                        //     $("#corrsiteResultDiv").html(paserMyJson(data));
                        //     $('#corrsitesurfshow').hide();
                        // }, 0);


                    }
                });
            }
        });


        $("#downloadBtn").click(function (e) {
            e.preventDefault();

            var obj = document.getElementsByName("mydownload");
            if (obj.length == 0) {
                alert("Please select current results!");
            } else {
                var check_val = "";
                var selected_PDB = "";
                for (var k in obj) {
                    if (obj[k].checked) {
                        var tmp1 = ":" + obj[k].value;
                        check_val = check_val + tmp1;
                    }
                }
                //         alert(check_val);
                $.ajax({
                    type: 'Post',
                    url: "compressallfiles.php",
                    data: {'checklabels': check_val},
                    beforeSend: function () {

                    },
                    success: function (urldata) {
                        //                     alert(urldata);
                        // window.open(urldata);
                        // setTimeout('window.open('+urldata+');', 500);
                        var tempwindow = window.open('_blank');
                        tempwindow.location.href = urldata;
                    }
                });
            }


        });


    });

})(jQuery);






