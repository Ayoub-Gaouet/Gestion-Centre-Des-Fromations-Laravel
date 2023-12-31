<x-main>
    <x-slot name="title">
        Gestion utilisateurs
    </x-slot>
    <x-slot name="cssSlot">
        <link href="{{asset("plugins/custom/datatables/datatables.bundle.css")}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset("plugins/select2/css/select2.min.css")}}">
        <link rel="stylesheet" href="{{asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    </x-slot>

    <x-slot name="subHeaderTitle">
        Utilisateurs
    </x-slot>
    <x-slot name="bodyContent">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-notepad text-primary"></i>
                            </span>
                    <h3 class="card-label">Listing des Utilisateurs</h3>
                </div>
                <div class="card-toolbar">

                    <a id="add" class=" text-white btn btn-success" data-toggle="modal"
                       data-target="#addModal">
                        <i class="fas fa-plus"></i> Ajouter</a>

                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table align-middle" id="kt_datatable">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>email_verified_at</th>
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
                        <th>Email</th>
                        <th>email_verified_at</th>
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
        {{--        add user modal--}}
        <x-modal modal-title="Ajouter un utilisateur" method="POST" route="register" form-id="addForm"
                 modal-name="addModal">
            <x-slot name="modalContent">
                @csrf
                <x-input-group labelclass="" id="name" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un Nom" grid="" step="" min=""/>

                <x-input-group labelclass="" id="email" name="email" labelname="Email" class="form-control" type="email"
                               placeholder="Entrer un Email" grid="" min="" step=""/>

                <x-input-group labelclass="" id="password" name="password" labelname="Mot de passe" class="form-control"
                               type="password"
                               placeholder="Entrer un mot de passe" grid="" min="" step=""/>

                <x-input-group labelclass="" id="password_confirmation" name="password_confirmation" labelname="Mot de passe"
                               class="form-control"
                               type="password"
                               placeholder="Confirmer le mot de passe" grid="" min="" step=""/>

            </x-slot>
        </x-modal>
        {{--        update user modal--}}
        <x-modal modal-title="Modifier un utilisateur" method="POST" route="users.update" form-id="updateForm"
                 modal-name="updateModal">
            <x-slot name="modalContent">
                @csrf
                @method('put')
                <x-input-group labelclass="" id="nameUpdate" name="name" labelname="Nom" class="form-control" type="text"
                               placeholder="Entrer un Nom" grid="" min="" step=""/>

                <x-input-group labelclass="" id="emailUpdate" name="email" labelname="Email" class="form-control" type="email"
                               placeholder="Entrer un Email" grid="" min="" step=""/>

            </x-slot>
        </x-modal>
        {{--        update password modal--}}
        <x-modal modal-title="Modifier le mot de passe" method="POST" route="users.changePasswordAccount"
                 form-id="updatePasswordForm"
                 modal-name="updatePassword" >

            <x-slot name="modalContent">
                @csrf
                @method('PUT')
                <x-input-group labelclass="" id="new_password" name="new_password" labelname="Nouveau mot de passe"
                               class="form-control"
                               type="password"
                               placeholder="Entrer un mot de passe" grid="" min="" step=""/>
                <x-input-group labelclass="" id="new_password_confirmation" name="new_password_confirmation"
                               labelname="Confirmer le nouveau mot de passe"
                               class="form-control"
                               type="password"
                               placeholder="Confirmer le mot de passe" grid="" min="" step=""/>
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
            $(document).on('shown.bs.modal', '#roleModalUser', function (evt) {
                select.trigger("change");
                $('.select2-ajax').trigger("change");
            });
        </script>
        <x-js-data-table route='{{route("users.index")}}' tableId="kt_datatable">

            <x-slot name="jsonColumns">
                {!! file_get_contents(public_path("js/pages/admin/users_datatable.js")) !!}
            </x-slot>
        </x-js-data-table>
        <script>
            var id;
            var name;
            var email;
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
                $("#updateForm").attr("action", "{{route("users.update",["user"=>""])}}" + "/" + id);
                name = $(this).data("name");
                email = $(this).data("email");
                $('#idUpdate').val(id);
                $('#nameUpdate').val(name);
                $('#emailUpdate').val(email);
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
                            url: "{{route('users.desactivateAccount',["user" => ''])}}" + "/" + id,
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
