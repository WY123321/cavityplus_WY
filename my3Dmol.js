$(document).ready(function () {

    let cavityContentShow = 0;
    let CavPharmerContentShow = 1;
    let CorSiteContentShow = 1;
    let CovCysContentShow = 1;
    let advancedContentShow = 1;
    $("#cavityTitle").click(function () {
            if (cavityContentShow == 0) {
                $('#cavityTitle').removeClass('active');
                $('#cavityContent').removeClass('active');
                cavityContentShow = 1;
            } else if (cavityContentShow == 1) {
                $('#cavityTitle').addClass('active');
                $('#cavityContent').addClass('active');
                cavityContentShow = 0;
            } else {
                console.log(error)
            }
        }
    )
    $("#cavPharmerTitle").click(function () {
            if (CavPharmerContentShow == 0) {
                $('#cavPharmerTitle').removeClass('active');
                $('#cavPharmerContent').removeClass('active');
                CavPharmerContentShow = 1;
            } else if (CavPharmerContentShow == 1) {
                $('#cavPharmerTitle').addClass('active');
                $('#cavPharmerContent').addClass('active');
                CavPharmerContentShow = 0;
            } else {
                console.log(error)
            }
        }
    )
    $("#corrSiteTitle").click(function () {
            if (CorSiteContentShow == 0) {
                $('#corrSiteTitle').removeClass('active');
                $('#corrSiteContent').removeClass('active');
                CorSiteContentShow = 1;
            } else if (CorSiteContentShow == 1) {
                $('#corrSiteTitle').addClass('active');
                $('#corrSiteContent').addClass('active');
                CorSiteContentShow = 0;
            } else {
                console.log(error)
            }
        }
    )
    $("#covCysTitle").click(function () {
            if (CovCysContentShow == 0) {
                $('#covCysTitle').removeClass('active');
                $('#covCysContent').removeClass('active');
                CovCysContentShow = 1;
            } else if (CovCysContentShow == 1) {
                $('#covCysTitle').addClass('active');
                $('#covCysContent').addClass('active');
                CovCysContentShow = 0;
            } else {
                console.log(error)
            }
        }
    )
    $("#advancedTitle").click(function () {
            if (advancedContentShow == 0) {
                $('#advancedTitle').removeClass('active');
                $('#advancedContent').removeClass('active');
                advancedContentShow = 1;
            } else if (advancedContentShow == 1) {
                $('#advancedTitle').addClass('active');
                $('#advancedContent').addClass('active');
                advancedContentShow = 0;
            } else {
                console.log(error)
            }
        }
    )

    $("#cavitySelect").change(function () {
        let type = $("#cavitySelect").val();
        if (type == "entry") {
            $("#PDBEntry").show();
            $("#PDBFile").hide();
        }
        if (type == "file") {
            $("#PDBEntry").hide();
            $("#PDBFile").show();
        }
    })


    $("#cmode_1").change(function () {
        $("#cligFile").hide();
    })

    $("#cmode_2").change(function () {
        $("#cligFile").show();
    })

    let element = $('#div_mol');
    let config = {backgroundColor: '#ffffff'};
    let viewer = $3Dmol.createViewer(element, config);

    $3Dmol.download("pdb:1UBQ", viewer, {}, function () {

        viewer.setStyle({}, {cartoon: {color: 'spectrum'}})
        chainsOperation(viewer);

        viewer.zoomTo();
        viewer.render();
        viewer.zoom(1.2, 1000);
    });


// let pdbUri = "./pdb/1db4.pdb"
// jQuery.ajax(pdbUri, {
//         success: function (data) {
//             console.log("成功")
//             let v = viewer;
//             v.addModel(data, "pdb");
//             v.setStyle({}, {cartoon: {color: 'spectrum'}});
//             v.zoomTo();
//             v.render();
//             v.zoom(1.2, 1000);
//         },
//         error: function (hdr, status, err) {
//             console.log("失败")
//             console.error("Failed to load PDB" + pdbUri + ":" + err);
//
//         }
//     }
// )

    $("#PDBEntry_Btn").click(function () {
        let pdbidstr = 'pdb:' + $('#PDBEntry_ID').val();
        // console.log(pdbidstr);
        viewer.clear();
        $3Dmol.download(pdbidstr, viewer, {}, function () {

            viewer.setBackgroundColor(0xffffffff);

            viewer.setStyle({}, {cartoon: {color: 'spectrum'}});

            // viewer.setStyle({chain: 'B'}, {cartoon: {hidden: true}});
            // viewer.setStyle({chain: 'B'}, {cartoon: {color: 'spectrum'}});

            chainsOperation(viewer);

            viewer.zoomTo();
            viewer.render();
            viewer.zoom(1.2, 1000);
        });
    });


    function chainsOperation(viewer) {
        let chains_all = [];
        let chains = [];
        let atoms = viewer.selectedAtoms();
        for (let i = 0; i < atoms.length; i++) {
            chains_all.push(atoms[i].chain);
        }

        for (let i = 0; i < chains_all.length; i++) {
            let items = chains_all[i];
            if ($.inArray(items, chains) == -1) {
                chains.push(items);
            }
        }
        let chainContent = ''
        for (let i = 0; i < chains.length; i++) {
            let chainId = "checkbox_" + chains[i];

            let contentTemp = '<div class="ui checkbox"><input class="group1" tabindex="0" type="checkbox" name="chain" id="' + chainId + '" checked="checked" value="' + chains[i] + '"> <label for="' + chainId + '">' + chains[i] + ' &nbsp;&nbsp;&nbsp;&nbsp;</label></div>'
            chainContent += contentTemp;
        }
        $("#content").html(chainContent);
        for (let i = 0; i < chains.length; i++) {
            let chainId = "#checkbox_" + chains[i];
            $(chainId).click(function () {
                console.log(chainId)
                console.log($(chainId).is('checked'))

                if ($(chainId).is('checked') === false) {
                    viewer.setStyle({chain: chains[i]}, {cartoon: {hidden: true}});
                    viewer.zoomTo();
                    viewer.render();
                    viewer.zoom(1.2, 0);
                } else {
                    viewer.setStyle({chain: chains[i]}, {cartoon: {color: 'spectrum'}});
                    viewer.zoomTo();
                    viewer.render();
                    viewer.zoom(1.2, 0);
                }
            })
        }

    }

    let readText = function (input, func) {
        if (input.files.length > 0) {
            let file = input.files[0];
            let reader = new FileReader();
            reader.onload = function (evt) {
                func(evt.target.result, file.name);
            }
            reader.readAsText(file);
            $(input).val('');
        }
    }
    $("#PDBFile_ID").change(function () {
        readText(this, function (data, name) {
            viewer.clear();
            viewer.addModel(data, name);
            viewer.setStyle({}, {cartoon: {color: 'spectrum'}});
            chainsOperation(viewer);
            viewer.zoomTo();
            viewer.render();
            viewer.zoom(1.2, 1000);
        });
    });

});
