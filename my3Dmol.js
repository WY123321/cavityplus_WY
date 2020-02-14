$(document).ready(function () {
    let element = $('#div1');
    let config = {backgroundColor: '#ffffff'};
    var viewer = $3Dmol.createViewer(element, config);

    // $3Dmol.download("pdb:1UBQ", viewer, {}, function () {
    //     console.log("加载")
    //     viewer.setBackgroundColor("ffffff");
    //     viewer.render();
    // });
    let pdbUri = "./pdb/1db4.pdb"
    jQuery.ajax(pdbUri, {
            success: function (data) {
                console.log("成功")
                let v = viewer;
                v.addModel(data, "pdb");
                v.setStyle({}, {cartoon: {color: 'spectrum'}});
                v.zoomTo();
                v.render();
                v.zoom(1.2, 1000);
            },
            error: function (hdr, status, err) {
                console.log("失败")
                console.error("Failed to load PDB" + pdbUri + ":" + err);

            }
        }
    )


    $("#btn1").click(function () {
        console.log("改变")
        console.log($('#pdbid').val())
        var pdbidstr = $('#pdbid').val();
        // $('#div1').attr("data-pdb",$('#pdbid').val());
        viewer.clear();
        $3Dmol.download('pdb:' + pdbidstr, viewer, {doAssembly: true, noSecondaryStructure: false});
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
    $("#input1").change(function () {
        console.log("文件")
        readText(this, function (data, name) {
            viewer.clear();
            viewer.addModel(data, name);
            viewer.setStyle({}, {cartoon: {color: 'spectrum'}});
            viewer.zoomTo();
            viewer.render();
        });
    });
});
