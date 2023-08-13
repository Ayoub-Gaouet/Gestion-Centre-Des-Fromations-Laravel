<x-main>
    <x-slot name="title">
        Gestion Formations
    </x-slot>
    <x-slot name="cssSlot">
        <link href="{{asset("plugins/custom/datatables/datatables.bundle.css")}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset("plugins/select2/css/select2.min.css")}}">
        <link rel="stylesheet" href="{{asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    </x-slot>

    <x-slot name="subHeaderTitle">
        Formations
    </x-slot>
    <x-slot name="bodyContent">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-notepad text-primary"></i>
                            </span>
                    <h3 class="card-label">Listing des Formations</h3>
                </div>
                <div class="card-toolbar">

                    <a id="add" class=" text-white btn btn-success" data-toggle="modal"
                       data-target="#addModal">
                        <i class="fas fa-plus"></i>Ajouter</a>

                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table align-middle" id="kt_datatable">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date_debut</th>
                        <th>Date_fin</th>
                        <th>Duree</th>
                        <th>Lieu</th>
                        <th>Prix</th>
                        <th>is_terminated</th>
                        <th>max_places</th>
                        <th>Formateur</th>
                        <th>Crée Le</th>
                        <th>Modifiée Le</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date_debut</th>
                        <th>Date_fin</th>
                        <th>Duree</th>
                        <th>Lieu</th>
                        <th>Prix</th>
                        <th>is_terminated</th>
                        <th>max_places</th>
                        <th>Formateur</th>
                        <th>Crée Le</th>
                        <th>Modifiée Le</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        {{--        add formation modal--}}
        <x-modal modal-title="Ajouter une formation" method="POST" route="formation.store" form-id="addForm"
                 modal-name="addModal">
            <x-slot name="modalContent">
                @csrf
                <x-input-group labelclass="" id="name" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un nom" grid="" step="" min=""/>

                <x-input-group labelclass="" id="description" name="description" labelname="Description" class="form-control" type="text"
                               placeholder="Entrer une description" grid="" step="" min=""/>

                <x-input-group labelclass="" id="date_debut" name="date_debut" labelname="Date de début" class="form-control" type="date"
                               placeholder="Sélectionnez une date de début" grid="" step="" min=""/>

                <x-input-group labelclass="" id="date_fin" name="date_fin" labelname="Date de fin" class="form-control" type="date"
                               placeholder="Sélectionnez une date de fin" grid="" step="" min=""/>

                <x-input-group labelclass="" id="duree" name="duree" labelname="Durée" class="form-control" type="number"
                               placeholder="Entrer une durée en jours" grid="" step="1" min="1"/>

                <x-input-group labelclass="" id="lieu" name="lieu" labelname="Lieu" class="form-control" type="text"
                               placeholder="Entrer un lieu" grid="" step="" min=""/>

                <x-input-group labelclass="" id="prix" name="prix" labelname="Prix" class="form-control" type="number"
                               placeholder="Entrer un prix" grid="" min="0" step="any"/>

                <x-select2 id="is_terminated" name="is_terminated" labelname="Terminé" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option value="0">Non</option>
                        <option value="1">Oui</option>
                    </x-slot>
                </x-select2>
                <x-input-group labelclass="" id="max_places" name="max_places" labelname="Nombre de places maximum" class="form-control" type="number"
                               placeholder="Entrer un nombre maximum de places" grid="" step="1" min="1"/>
                <x-select2 id="formateur" name="formateur" labelname="Formateur" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($formateurs as $formateur)
                            <option value="{{$formateur->id}}">{{$formateur->name}}</option>

                        @endforeach
                    </x-slot>
                </x-select2>
            </x-slot>
        </x-modal>
        {{--        update formation modal--}}
        <x-modal modal-title="Modifier un Formation" method="POST" route="formations.update" form-id="updateForm"
                 modal-name="updateModal">
            <x-slot name="modalContent">
                @csrf
                @method('put')
                <x-input-group labelclass="" id="nameUpdate" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un nom" grid="" step="" min=""/>

                <x-input-group labelclass="" id="descriptionUpdate" name="description" labelname="Description" class="form-control" type="text"
                               placeholder="Entrer une description" grid="" step="" min=""/>

                <x-input-group labelclass="" id="date_debutUpdate" name="date_debut" labelname="Date de début" class="form-control" type="date"
                               placeholder="Sélectionnez une date de début" grid="" step="" min=""/>

                <x-input-group labelclass="" id="date_finUpdate" name="date_fin" labelname="Date de fin" class="form-control" type="date"
                               placeholder="Sélectionnez une date de fin" grid="" step="" min=""/>

                <x-input-group labelclass="" id="dureeUpdate" name="duree" labelname="Durée" class="form-control" type="number"
                               placeholder="Entrer une durée en jours" grid="" step="1" min="1"/>

                <x-input-group labelclass="" id="lieuUpdate" name="lieu" labelname="Lieu" class="form-control" type="text"
                               placeholder="Entrer un lieu" grid="" step="" min=""/>

                <x-input-group labelclass="" id="prixUpdate" name="prix" labelname="Prix" class="form-control" type="number"
                               placeholder="Entrer un prix" grid="" min="0" step="any"/>

                <x-select2 id="is_terminatedUpdate" name="is_terminated" labelname="Terminé" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option value="0">Non</option>
                        <option value="1">Oui</option>
                    </x-slot>
                </x-select2>
                <x-input-group labelclass="" id="max_placesUpdate" name="max_places" labelname="Nombre de places maximum" class="form-control" type="number"
                               placeholder="Entrer un nombre maximum de places" grid="" step="1" min="1"/>
                <x-select2 id="formateurUpdate" name="formateur" labelname="Formateur" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($formateurs as $formateur)
                            <option value="{{$formateur->id}}">{{$formateur->name}}</option>

                        @endforeach
                    </x-slot>
                </x-select2>
            </x-slot>
        </x-modal>
    </x-slot>

    <x-slot name="jsSlot">

        <script src="{{asset("plugins/custom/datatables/datatables.bundle.js")}}"></script>
        <script src="{{asset("plugins/jquery-validation/jquery.validate.min.js")}}"></script>
        <script src="{{asset("plugins/jquery-validation/additional-methods.min.js")}}"></script>
        <script src="{{asset("plugins/jquery-validation/localization/messages_fr.min.js")}}"></script>
        <script src="{{asset("plugins/select2/js/i18n/fr.js")}}"></script>
        <script src="{{asset("plugins/select2/js/select2.full.min.js")}}"></script>
        <script src="{{asset("js/pages/crud/forms/widgets/bootstrap-datetimepicker.js")}}"></script>
        <script>
            var select = $('.select2').select2();
            $(document).on('shown.bs.modal', '#roleModalUformation', function (evt) {
                select.trigger("change");
                $('.select2-ajax').trigger("change");
            });
        </script>
        <x-js-data-table route='{{route("formations.index")}}' tableId="kt_datatable">

            <x-slot name="jsonColumns">
                {!! file_get_contents(public_path("js/pages/formation/formations_datatable.js")) !!}
            </x-slot>
        </x-js-data-table>
        <script>
            var id;
            var name;
            var description;
            var date_debut;
            var date_fin;
            var duree;
            var lieu;
            var prix;
            var is_terminated;
            var max_places;

            $('#updateForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    description: {
                        required: true,
                        minlength: 2
                    },
                    date_debut: {
                        required: true
                    },
                    date_fin: {
                        required: true
                    },
                    duree: {
                        required: true,
                        min: 1
                    },
                    lieu: {
                        required: true,
                        minlength: 2
                    },
                    prix: {
                        required: true,
                        min: 0
                    },
                    is_terminated: {
                        required: true
                    },
                    max_places: {
                        required: true
                    }

                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('body').on('click', '.edit', function () {
                id = $(this).data("id");
                $("#updateForm").attr("action", "{{route("formations.update",["formation"=>""])}}" + "/" + id);
                $('#nameUpdate').val($(this).data("name"));
                $('#descriptionUpdate').val($(this).data("description"));
                date_debut = new Date($(this).data("date_debut"));
                $('#date_debutUpdate').val(date_debut.toISOString().substring(0, 10));
                date_fin = new Date($(this).data("date_fin"));
                $('#date_finUpdate').val(date_fin.toISOString().substring(0, 10));
                $('#dureeUpdate').val($(this).data("duree"));
                $('#lieuUpdate').val($(this).data("lieu"));
                $('#prixUpdate').val($(this).data("prix"));
                $('#is_terminatedUpdate').val($(this).data("is_terminated")).trigger("change");
                $('#max_placesUpdate').val($(this).data("max_places"));
                $('#formateurUpdate').val($(this).data("formateur")).trigger("change");
            });
        </script>
        <script>
            var id;

            $('body').on('click', '.delete_formation', function () {
                id = $(this).data("id");
                var message = "Are you sure you want to delete this formation?";
                swal.fire({
                    title: "Confirm Delete",
                    text: message,
                    icon: 'warning',
                    buttons: {
                        cancel: true,
                        delete: 'Yes'
                    }
                }).then(function (willDelete) {
                    if (willDelete) {
                        $.ajax({
                            method: 'delete',
                            dataType: 'json',
                            data: {"_method": 'delete', "_token": "{{csrf_token()}}"},
                            url: "{{route('formations.destroy',["formation" => ''])}}" + "/" + id,
                            success: function (data) {
                                if (!data.error) {
                                    swal.fire({
                                        title: 'Success',
                                        text: data.message,
                                        icon: 'success'
                                    });
                                    location.reload();
                                }else {
                                    swal.fire({
                                        title: 'Erreur',
                                        text: data.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function (data) {
                                console.log(data.responseText);
                                console.log("error");
                                location.reload();
                            }
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-main>
