$(document).ready(function(){
    $('.service').css('color', '#FF4A07');


    $(".desactiver").click(function(){
        var value = $(this).parents('div').find('.divIDCatalogue').text();
        $(location).attr('href',"../Controleur/cToggleService.php?id="+value);
    });

    $(".ajouter").click(function(){
        $("#modalService").modal();
    });

    $(".modifier").click(function(){
        var idService = $(this).parents('div').find('.divIDCatalogue').text();
        var imgService = $(this).parents('div').find('.divImageService').children('img#produitImage').attr("src");
        var nomService = $(this).parents('div').find('.divContenuService').children('p#titreProd').text();
        var descService = $(this).parents('div').find('.divContenuService').children('p#descProd').text();
        var heureService = $(this).parents('div').find('.divContenuService').children('p#duree').text();
        var tarifService = $(this).parents('div').find('.divContenuService').children('p#tarif').text();
        var actif = $(this).parent().siblings().children().text();
        if(actif == 'Désactiver le service'){
            $('input[name=actif]').attr('checked', true);
        }else{
            $('input[name=actif]').attr('checked', false);
        }
        heureService = heureService.replace(/[^\d.-]/g, '');
        tarifService = tarifService.replace(/[^\d.-]/g, '');

        $('#idService').val(idService);
        $('#produitImageModal').attr("src", imgService);
        $('#nomService').val(nomService);
        $('#descService').val(descService);
        $('#heureService').val(heureService);
        $('#tarifService').val(tarifService);

        $("#modalService").modal();
    });

    $(function () {
        $("#file").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $('#produitImageModal').attr('src', e.target.result);
    };

    // this is the id of the form
    $("#formService").submit(function(e) {
        var url;
        if($('#idService').val() == 0){
            url = "../Controleur/cAjoutService.php"; // the script where you handle the form input.
        }else{
            url = "../Controleur/cModifService.php"; // the script where you handle the form input.
        }

        var form = $('#formService')[0];

        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: url,
            data: formData, // serializes the form's elements.
            processData: false,
            contentType: false,
            success: function()
            {

                $.ajax({
                    url: "",
                    context: document.body,
                    success: function (s, x) {
                        $('#modalService').modal('hide');
                        $('body').removeClass('modal-open');
                        $(this).html(s);
                        $('.dropdown-toggle').dropdown();
                    }
                });
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#formPromotion").submit(function(e){
        var dateStart = $('#dateStart').val().replace('-','/').replace('-','/');
        var dateEnd = $('#dateEnd').val().replace('-','/').replace('-','/');
        if(dateStart >= dateEnd || dateEnd <= dateStart){
            e.preventDefault();
            alert("La date de départ ne peut pas être après la date de fin et vice versa.");
        }else{
            var url = "../Controleur/cServicePromotion.php";
            var form = $('#formPromotion')[0];

            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: url,
                data: formData, // serializes the form's elements.
                processData: false,
                contentType: false,
                success: function()
                {

                    $.ajax({
                        url: "",
                        context: document.body,
                        success: function (s, x) {
                            $('#myModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', 0);
                            $(this).html(s);
                            $('.dropdown-toggle').dropdown();
                        }
                    });
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        }
    });

    $(".ajouterPromoService").click(function(){
        $('.percentagePromotion').html("0%");
        var idService = $(this).parents('div').find('.divIDCatalogue').text();
        $('#idServiceModal').val(idService);

        $('select').attr('disabled',false);
        $("#myModal").modal();
    });

    $(".modifierRabais").click(function(){
        var idService = $(this).parents('div').find('.divIDCatalogue').text();
        var titreRabais = $(this).parents('div').find('.divIDRabais').find('.titreRabais').text();

        var percentage = $(this).closest('div').siblings('a.noDeco').children('p#promoNumberText').text();
        var idRabais = $(this).parents('div').find('.divIDRabais').find('.idRabais').text();
        var idPromoService = $(this).parents('div').find('.divIDRabais').find('.idPromoService').text();
        var dateStart = $(this).parents('div').find('.divIDRabais').find('.startDateRabais').text();
        var dateEnd = $(this).parents('div').find('.divIDRabais').find('.endDateRabais').text();

        $("select option").each(function(){
            if($(this).val()==titreRabais){
                $(this).attr("selected","selected");
            }
        });
        $('select').attr('disabled',true);
        $('.percentagePromotion').html(percentage);
        $('.idRabaisModal').html(idRabais);
        $('.idPromoServiceModal').html(idPromoService);


        $('#percentSentData').val(percentage);
        $('#idServiceModal').val(idService);
        $('#idRabaisModal').val(idRabais);
        $('#idPromoServiceModal').val(idPromoService);
        $('#dateStart').val(dateStart);
        $('#dateEnd').val(dateEnd);

        $("#myModal").modal();
    });

    $(".supprimerRabais").click(function(){
        var pkPromoService = $(this).parent().parent().parent().siblings('div.divIDRabais').children('p.idPromoService').text();

        if(confirm("Voulez-vous vraiment supprimer cette promotion liée a ce service?")){
            $(location).attr('href',"../Controleur/cServicePromotion.php?id="+pkPromoService+"&eventid=1");
        }
        else{
            return false;
        }

    });

    $("formPromotion").submit(function(e){
        var dateStart = $('#dateStart').val().replace('-','/').replace('-','/');
        var dateEnd = $('#dateEnd').val().replace('-','/').replace('-','/');
        if(dateStart >= dateEnd || dateEnd <= dateStart){
            e.preventDefault();
            alert("La date de départ ne peut pas être après la date de fin et vice versa.");
        }
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        $(this)
            .find("input[type=text],textarea,input[type=date]")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        // remove "selected" from any options that might already be selected
        $('form option[selected="selected"]').each(
            function() {
                $(this).removeAttr('selected');
            }
        );


        // mark the first option as selected
        $("formoption:first").attr('selected','selected');
    });

    $('#modalService').on('hidden.bs.modal', function (e) {
        $(this)
            .find("input[type=text],textarea,input[type=date]")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        // remove "selected" from any options that might already be selected
        $('form option[selected="selected"]').each(
            function() {
                $(this).removeAttr('selected');
            }
        );


        // mark the first option as selected
        $("formoption:first").attr('selected','selected');
    });

    $('[data-toggle="tooltip"]').tooltip();
});