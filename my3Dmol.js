$(document).ready(function () {
    // 1DB4  6rh8 2amd
    let defaultModel = "1UBQ";
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
        } else {
            $('#cavityTitle').addClass('active');
            $('#cavityContent').addClass('active');
            cavityContentShow = 0;
        }
    })
    $("#cavPharmerTitle").click(function () {
        if (CavPharmerContentShow == 0) {
            $('#cavPharmerTitle').removeClass('active');
            $('#cavPharmerContent').removeClass('active');
            CavPharmerContentShow = 1;
        } else {
            $('#cavPharmerTitle').addClass('active');
            $('#cavPharmerContent').addClass('active');
            CavPharmerContentShow = 0;
        }
    })
    $("#corrSiteTitle").click(function () {
        if (CorSiteContentShow == 0) {
            $('#corrSiteTitle').removeClass('active');
            $('#corrSiteContent').removeClass('active');
            CorSiteContentShow = 1;
        } else {
            $('#corrSiteTitle').addClass('active');
            $('#corrSiteContent').addClass('active');
            CorSiteContentShow = 0;
        }
    })
    $("#covCysTitle").click(function () {
        if (CovCysContentShow == 0) {
            $('#covCysTitle').removeClass('active');
            $('#covCysContent').removeClass('active');
            CovCysContentShow = 1;
        } else {
            $('#covCysTitle').addClass('active');
            $('#covCysContent').addClass('active');
            CovCysContentShow = 0;
        }
    })
    $("#advancedTitle").click(function () {
        if (advancedContentShow == 0) {
            $('#advancedTitle').removeClass('active');
            $('#advancedContent').removeClass('active');
            advancedContentShow = 1;
        } else {
            $('#advancedTitle').addClass('active');
            $('#advancedContent').addClass('active');
            advancedContentShow = 0;
        }
    })

    $("#cavitySelect").change(function () {
        let type = $("#cavitySelect").val();
        if (type == "entry") {
            $("#PDBEntry").show();
            $("#PDBFile").hide();
        } else if (type == "file") {
            $("#PDBEntry").hide();
            $("#PDBFile").show();
        } else {
            console.log(error)
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


    $3Dmol.download("pdb:" + defaultModel, viewer, {}, function () {
        viewer.setStyle({}, {cartoon: {color: 'spectrum'}})
        chainsOperation(viewer);
        viewer.zoomTo();
        viewer.render();
        viewer.zoom(1.2, 1000);
    });

    $("#PDBEntry_Btn").click(function () {
        let pdbidstr = 'pdb:' + $('#PDBEntry_ID').val();


        viewer.clear();
        $3Dmol.download(pdbidstr, viewer, {}, function () {
            viewer.setBackgroundColor(0xffffffff);
            viewer.setStyle({}, {cartoon: {color: 'spectrum'}});

            chainsOperation(viewer);

            viewer.zoomTo();
            viewer.render();
            viewer.zoom(1.2, 1000);
        });
    });

    $("#PDBFile_ID").change(function () {
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

    function chainsOperation(viewer) {

        let chains_all = [];//所有AB
        let chains = [];//去重后AB

        let resn_all = [];//[9IN]A:1001
        let resn = [];//
        let atoms = viewer.selectedAtoms();
        console.log(atoms)


        for (let i = 0; i < atoms.length; i++) {//所有的AB拼接的一个数组
            chains_all.push(atoms[i].chain);
            if (atoms[i].hetflag == true && atoms[i].resn != "HOH") {
                resn_all.push("[" + atoms[i].resn + "]" + atoms[i].chain + ":" + atoms[i].resi)
            }
        }
        console.log(chains_all);
        console.log(resn_all);


        for (let i = 0; i < chains_all.length; i++) {//去重 只剩下A
            let items = chains_all[i];
            if ($.inArray(items, chains) == -1) {
                chains.push(items);
            }
        }
        console.log(chains)

        for (let i = 0; i < resn_all.length; i++) {//去重 只剩下[9IN]A:1001
            let items = resn_all[i];
            if ($.inArray(items, resn) == -1) {
                resn.push(items);
            }
        }
        console.log(resn)


        let chainContent = ''
        let chainsCheckbox = [];//多选框的选中状态通过1_A 的1或者0来确定
        for (let i = 0; i < chains.length; i++) {

            let chainId = "checkbox_" + chains[i];
            chainsCheckbox.push('1_' + chains[i])
            let contentTemp = '<div class="ui checkbox"><input class="group1" tabindex="0" type="checkbox" name="chain" id="' + chainId + '" checked="checked" value="' + chains[i] + '"> <label for="' + chainId + '">' + chains[i] + ' &nbsp;&nbsp;&nbsp;&nbsp;</label></div>'
            chainContent += contentTemp;
        }
        $("#content").html(chainContent);


        for (let i = 0; i < chains.length; i++) {//给多选框添加单击事件,控制蛋白质显示或者隐藏
            $("#checkbox_" + chains[i]).click(function () {

                if (chainsCheckbox[i].substr(0, 1) == 1) {

                    chainsCheckbox[i] = '0' + chainsCheckbox[i].substr(1);
                    // console.log(chainsCheckbox[i])
                    viewer.setStyle({chain: chains[i]}, {cartoon: {hidden: true}});
                    viewer.zoomTo();
                    viewer.render();
                    viewer.zoom(1.2, 0);
                } else {
                    chainsCheckbox[i] = '1' + chainsCheckbox[i].substr(1);
                    // console.log(chainsCheckbox[i])
                    viewer.setStyle({chain: chains[i]}, {cartoon: {color: 'spectrum'}});
                    viewer.zoomTo();
                    viewer.render();
                    viewer.zoom(1.2, 0);
                }
            })
        }
        $('#pdbligand').empty();
        let pdbligandContent = '    <option selected="selected" value="0">none</option> '

        for (let i = 0; i < resn.length; i++) {
            pdbligandContent += '    <option  value=" ' + resn[i] + ' ">' + resn[i] + '</option> ';
        }

        $("#pdbligand").html(pdbligandContent);

        if (resn.length > 0) {
            $('#pdbligand').prop('disabled', false);
        } else {
            $('#pdbligand').prop('disabled', true);
        }

    }




});
