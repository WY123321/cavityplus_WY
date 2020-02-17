$(document).ready(function () {

    let cavityContentShow = 0;
    let CavPharmerContentShow = 0;
    let CorSiteContentShow = 0;
    let CovCysContentShow = 0;
    $("#cavityTitle").click(function () {
            if (cavityContentShow == 0) {
                $('#cavityContent').removeClass('active');
                cavityContentShow = 1;
            } else if (cavityContentShow == 1) {

                $('#cavityContent').addClass('active');
                cavityContentShow = 0;
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


    let element = $('#div_3dmol');
    let config = {backgroundColor: '#ffffff'};
    let viewer = $3Dmol.createViewer(element, config);

    $3Dmol.download("pdb:1UBQ", viewer, {}, function () {
        viewer.setStyle({}, {cartoon: {color: 'spectrum'}});
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
            // viewer.setStyle({chain:'A'},{cross:{hidden:true}});

            viewer.zoomTo();
            viewer.render();
            viewer.zoom(1.2, 1000);
        });
    });


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
            viewer.zoomTo();
            viewer.render();
            viewer.zoom(1.2, 1000);
        });
    });

});
