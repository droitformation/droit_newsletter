$( function() {

    $('.redactor').redactor({
        minHeight  : 250,
        maxHeight: 450,
        focus: true,
        lang: 'fr',
        plugins: ['imagemanager','filemanager','source','iconic','alignment'],
        fileUpload : 'admin/uploadFileRedactor?_token=' + $('meta[name="_token"]').attr('content'),
        imageUpload: 'admin/uploadRedactor?_token=' + $('meta[name="_token"]').attr('content'),
        imageManagerJson: 'admin/imageJson',
        fileManagerJson: 'admin/fileJson',
        buttons    : ['format','bold','italic','|','lists','|','image','file','link','alignment']
    });

    $('.redactorSimple').redactor({
        minHeight: 50,
        maxHeight: 100,
        lang: 'fr',
        focus    : true,
        buttons  : ['format','bold','italic','|','lists']
    });

    $.fn.datepicker.dates['fr'] = {
        days: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        daysShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        daysMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        months: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthsShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
        today: "Aujourd'hui",
        clear: "Clear"
    };

    $('.datePicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'fr'
    });

    $('body').on('click','.deleteAction',function(event){

        var $this  = $(this);
        var action = $this.data('action');
        var what   = $this.data('what');

        var what = (0 === what.length ? 'supprimer' : what);
        var answer = confirm('Voulez-vous vraiment ' + what + ' : '+ action +' ?');

        if (answer)
        {
            return true;
        }

        return false;
    });

    // The url to the application
    var base_url = location.protocol + "//" + location.host+"/";

    $('#multi-select').multiSelect({
        selectableHeader: "<input type='text' class='form-control' style='margin-bottom: 10px;'  autocomplete='off' placeholder='Rechercher par nom'>",
        selectionHeader : "<input type='text' class='form-control' style='margin-bottom: 10px;' autocomplete='off' placeholder='Rechercher par nom'>",
        afterInit: function(ms){

            var that = this,
                $selectableSearch      = that.$selectableUl.prev(),
                $selectionSearch       = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString  = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
                if (e.which === 40){
                    that.$selectableUl.focus();
                    return false;
                }
            });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e){
                if (e.which == 40){
                    that.$selectionUl.focus();
                    return false;
                }
            });

        },
        afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
        }
    });


    $('#typeSelect').change(function()
    {
        if($(this).val() == 'product')
        {
            $('#productSelect').show();
        }
        else
        {
            $('#productSelect').hide();
        }
    });

    $('.colorpicker').colorPicker();

    /**
     *  Modal for delete a categorie as warning if arrets linked
     */
    $('body').on('click','.deleteCategorie',function(event){

        $('#modalCategorie').empty();

        var $this  = $(this);
        var id     = $this.data('id');

        $.ajax({
            url     : 'admin/ajax/categorie/arrets',
            data    : { id: id, _token: $("meta[name='_token']").attr('content') },
            type    : "POST",
            success : function(data) {
                if(data.length > 0)
                {
                    var references = '<p class="text-danger"><strong>Attention!</strong>Les arrêts suivant sont liés à cette catégorie</p><ul>';

                    $.each(data, function( index, value ) {
                        var item = '<li>'+ value +'</li>';
                        references = references.concat(item);
                    });

                    references.concat('</ul>');

                    $('#modalCategorie').append(references);
                }

                $('#deleteConfirm').data('categorie' , id);
                $('#deleteCategorie').modal();
            }
        });
    });

    $('#deleteConfirm').click(function() {
        var cat = $(this).data('categorie');
        console.log(cat);
        $('#deleteCategorieForm_' + cat).submit();
    });

});