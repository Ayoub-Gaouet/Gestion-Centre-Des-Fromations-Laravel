<x-main>
    <x-slot name="title">
        Gestion Inscriptions
    </x-slot>
    <x-slot name="cssSlot">
        <link href="{{asset("plugins/custom/datatables/datatables.bundle.css")}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset("plugins/select2/css/select2.min.css")}}">
        <link rel="stylesheet" href="{{asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    </x-slot>

    <x-slot name="subHeaderTitle">
        Inscriptions
    </x-slot>
    <x-slot name="bodyContent">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-notepad text-primary"></i>
                            </span>
                    <h3 class="card-label">Listing des Inscriptions</h3>
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
                        <th>Date_inscription</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Eval</th>
                        <th>Date_eval</th>
                        <th>Commentaire</th>
                        <th>Formation</th>
                        <th>Client</th>
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
                        <th>Date_inscription</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Eval</th>
                        <th>Date_eval</th>
                        <th>Commentaire</th>
                        <th>Formation</th>
                        <th>Client</th>
                        <th>Crée Le</th>
                        <th>Modifiée Le</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        {{--        add inscriptions modal--}}
        <x-modal modal-title="Ajouter une inscription" method="POST" route="inscription.store" form-id="addForm"
                 modal-name="addModal">
            <x-slot name="modalContent">
                @csrf
                <x-input-group labelclass="" id="date_inscription" name="date_inscription" labelname="date d'inscription" class="form-control" type="date"
                               placeholder="Sélectionnez une date d'inscription " grid="" step="" min=""/>

                <x-input-group labelclass="" id="montant" name="montant" labelname="Montant" class="form-control" type="number"
                               placeholder="Entrer Montant" grid="" min="0" step="any"/>

                <x-input-group labelclass="" id="eval" name="eval" labelname="Eval" class="form-control" type="integer"
                               placeholder="Eval" grid="" step="" min="1" max="5"/>

                <x-input-group labelclass="" id="date_eval" name="date_eval" labelname="date d'evaluation" class="form-control" type="date"
                               placeholder="Entrer date d'evaluation" grid="" step="" min=""/>

                <x-input-group labelclass="" id="commentaire" name="commentaire" labelname="Commentaire" class="form-control" type="String"
                               placeholder="Entrer Commentaire" grid="" step="" min=""/>

                <x-select2 id="formation" name="formation" labelname="Formation" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($formations as $formation)
                            <option value="{{$formation->id}}">{{$formation->name}}</option>

                        @endforeach
                    </x-slot>
                </x-select2>
                <x-select2 id="client" name="client" labelname="Client" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>

                        @endforeach
                    </x-slot>
                </x-select2>
            </x-slot>
        </x-modal>
        {{--        update inscriptions modal--}}
        <x-modal modal-title="Modifier une Inscription" method="POST" route="inscriptions.update" form-id="updateForm"
                 modal-name="updateModal">
            <x-slot name="modalContent">
                @csrf
                @method('put')
                <x-input-group labelclass="" id="date_inscriptionUpdate" name="date_inscription" labelname="date d'inscription" class="form-control" type="date"
                               placeholder="Sélectionnez une date d'inscription " grid="" step="" min=""/>

                <x-input-group labelclass="" id="montantUpdate" name="montant" labelname="Montant" class="form-control" type="number"
                               placeholder="Entrer Montant" grid="" min="0" step="any"/>

                <x-input-group labelclass="" id="evalUpdate" name="eval" labelname="Eval" class="form-control" type="integer"
                               placeholder="Eval" grid="" step="" min="1" max="5"/>

                <x-input-group labelclass="" id="date_evalUpdate" name="date_eval" labelname="date d'evaluation" class="form-control" type="date"
                               placeholder="Entrer date d'evaluation" grid="" step="" min=""/>

                <x-input-group labelclass="" id="commentaireUpdate" name="commentaire" labelname="Commentaire" class="form-control" type="String"
                               placeholder="Entrer Commentaire" grid="" step="" min=""/>

                <x-select2 id="formationUpdate" name="formation" labelname="Formation" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($formations as $formation)
                            <option value="{{$formation->id}}">{{$formation->name}}</option>

                        @endforeach
                    </x-slot>
                </x-select2>
                <x-select2 id="clientUpdate" name="client" labelname="Client" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option></option>
                        @foreach($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>

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
            $(document).on('shown.bs.modal', '#roleModalUInscription', function (evt) {
                select.trigger("change");
                $('.select2-ajax').trigger("change");
            });
        </script>
        <x-js-data-table route='{{route("inscriptions.index")}}' tableId="kt_datatable">

            <x-slot name="jsonColumns">
                {!! file_get_contents(public_path("js/pages/inscription/inscriptions_datatable.js")) !!}
            </x-slot>
        </x-js-data-table>
        <script>
            var id;
            var client;
            var formation;
            var date_inscription;
            var montant;

            $('#updateForm').validate({
                rules: {
                    client_id: {
                        required: true
                    },
                    formation_id: {
                        required: true
                    },
                    date_inscription: {
                        required: true
                    },
                    montant: {
                        required: true,
                        min: 0
                    },
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
                $("#updateForm").attr("action", "{{route("inscriptions.update",["inscription"=>""])}}" + "/" + id);
                $('#clientUpdate').val($(this).data("client")).trigger("change");
                $('#formationUpdate').val($(this).data("formation")).trigger("change");
                date_inscription = new Date($(this).data("date_inscription"));
                $('#date_inscriptionUpdate').val(date_inscription.toISOString().substring(0, 10));
                $('#montantUpdate').val($(this).data("montant"));
                $('#etatUpdate').val($(this).data("etat")).trigger("change");
                $('#evalUpdate').val($(this).data("eval"));
                dateEval = new Date($(this).data("dateEval"));
                $('#dateEvalUpdate').val(dateEval.toISOString().substring(0, 10));
                $('#commentaireUpdate').val($(this).data("commentaire"));
            });
        </script>

        <script>
            var id;

            $('body').on('click', '.delete_inscription', function () {
                id = $(this).data("id");
                var message = "Are you sure you want to delete this inscription?";
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
                            url: "{{route('inscriptions.destroy',["inscription" => ''])}}" + "/" + id,
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
