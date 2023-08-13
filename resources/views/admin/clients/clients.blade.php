<x-main>
    <x-slot name="title">
        Gestion Client
    </x-slot>
    <x-slot name="cssSlot">
        <link href="{{asset("plugins/custom/datatables/datatables.bundle.css")}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset("plugins/select2/css/select2.min.css")}}">
        <link rel="stylesheet" href="{{asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    </x-slot>

    <x-slot name="subHeaderTitle">
        Clients
    </x-slot>
    <x-slot name="bodyContent">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-notepad text-primary"></i>
                            </span>
                    <h3 class="card-label">Listing des Clients</h3>
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
                        <th>Date de naissance</th>
                        <th>genre</th>
                        <th>tel</th>
                        <th>Email</th>
                        <th>Status</th>
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
                        <th>Date de naissance</th>
                        <th>genre</th>
                        <th>tel</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Crée Le</th>
                        <th>Modifiée Le</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        {{--        add client modal--}}
        <x-modal modal-title="Ajouter un client" method="POST" route="register" form-id="addForm"
                 modal-name="addModal">
            <x-slot name="modalContent">
                @csrf
                <x-input-group labelclass="" id="name" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un Nom" grid="" step="" min=""/>
                <x-input-group labelclass="" id="date_de_naissance" name="date_de_naissance" labelname="Date de naissance" class="form-control" type="date"
                               placeholder="Entrer une date de naissance"  step="" grid="" min=""/>
                <x-select2 id="genre" name="genre" labelname="Genre" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option>Male</option>
                        <option>Female</option>
                    </x-slot>
                </x-select2>
                <x-input-group labelclass="" id="tel" name="tel" labelname="Tel" class="form-control" type="text"
                               placeholder="Entrer un Tel" grid="" step="" min=""/>
                <x-input-group labelclass="" id="email" name="email" labelname="Email" class="form-control" type="email"
                               placeholder="Entrer un Email" grid="" min="" step=""/>

                <x-input-group labelclass="" id="password" name="password" labelname="Mot de passe" class="form-control"
                               type="password"
                               placeholder="Entrer un mot de passe" grid="" min="" step=""/>
            </x-slot>
        </x-modal>
        {{--        update client modal--}}
        <x-modal modal-title="Modifier un Client" method="POST" route="clients.update" form-id="updateForm"
                 modal-name="updateModal">
            <x-slot name="modalContent">
                @csrf
                @method('put')
                <x-input-group labelclass="" id="nameUpdate" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un Nom" grid="" min="" step=""/>
                <x-input-group labelclass="" id="date_de_naissanceUpdate" name="date_de_naissance" labelname="Date de naissance" class="form-control" type="date"
                               placeholder="Sélectionnez une date de naissance" grid="" step="" min=""/>
                <x-select2 id="genreUpdate" name="genre" labelname="Genre" class="select2"
                           required="required" multiple="" grid="">
                    <x-slot name="content">
                        <option>Male</option>
                        <option>Female</option>
                    </x-slot>
                </x-select2>
                <x-input-group labelclass="" id="telUpdate" name="tel" labelname="Tel" class="form-control" type="text"
                               placeholder="Entrer un Tel" grid="" step="" min=""/>
                <x-input-group labelclass="" id="emailUpdate" name="email" labelname="Email" class="form-control" type="email"
                               placeholder="Entrer un Email" grid="" min="" step=""/>
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
            $(document).on('shown.bs.modal', '#roleModalUClient', function (evt) {
                select.trigger("change");
                $('.select2-ajax').trigger("change");
            });
        </script>
        <x-js-data-table route='{{route("clients.index")}}' tableId="kt_datatable">

            <x-slot name="jsonColumns">
                {!! file_get_contents(public_path("js/pages/client/clients_datatable.js")) !!}
            </x-slot>
        </x-js-data-table>
        <script>
            var id;
            var name;
            var email;
            var date_de_naissance;

            $('#updateForm').validate({
                rules: {
                    nameUpdate: {
                        required: true,
                        minlength: 2
                    },
                    emailUpdate: {
                        required: true,
                        email: true
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
                $("#updateForm").attr("action", "{{route("clients.update",["client"=>""])}}" + "/" + id);
                $('#nameUpdate').val($(this).data("name"));
                date_de_naissance = new Date($(this).data("date_de_naissance"));
                $('#date_de_naissanceUpdate').val(date_de_naissance.toISOString().substring(0, 10));
                $('#genreUpdate').val($(this).data("genre")).trigger("change");
                $('#telUpdate').val($(this).data("tel"));
                $('#emailUpdate').val($(this).data("email"));
            });
        </script>
        <script>
            $('body').on('click', '.desactiver', function () {
                console.log('status');
                var id = $(this).data("id");
                var message = $(this).data("name");
                swal.fire({
                    title: "Êtes-vous sûr ?",
                    text: message + id,
                    icon: 'warning',
                    buttons: {
                        cancel: true,
                        delete: 'Oui !'
                    }
                }).then(function (willDelete) {
                    if (willDelete) {
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            data: {"_method": 'delete', "_token": "{{csrf_token()}}"},
                            url: "{{route('clients.desactivateAccount',["client" => ''])}}" + "/" + id,
                            success: function (data) {
                                if (!data.error) {
                                    swal.fire({
                                        title: 'Succès',
                                        text: "Opération effectuée avec succès",
                                        icon: 'success'
                                    });
                                    location.reload();
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
            })
        </script>
    </x-slot>
</x-main>
