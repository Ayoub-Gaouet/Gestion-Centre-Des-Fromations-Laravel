<x-main-guest-layout :route='"register-client"' :route-param="['formation'=>$formation->id]" cardTitle="Inscrivez-vous" cardDescription="Entrez vos informations">
    <x-slot name="validation">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
    </x-slot>
    <x-slot name="formContent">
        <x-input-group labelclass="" id="name" name="name" labelname="Nom" class="form-control" type="text"
                       placeholder="Entrer un Nom" grid="" step="" min=""/>
        <x-input-group labelclass="" id="date_de_naissance" name="date_de_naissance" labelname="Date de naissance" class="form-control" type="date"
                       placeholder="Entrer une date de naissance"  step="" grid="" min=""/>

        <x-select2 id="genre" name="genre" labelname="Genre" class="select2"
                   class="form-control" required="required" multiple="" grid="">
            <x-slot name="content">
                <option>Male</option>
                <option>Female</option>
            </x-slot>
        </x-select2>

        <x-input-group labelclass="" id="tel" name="tel" labelname="Tel" class="form-control" type="text"
                       placeholder="Entrer un Tel" grid="" step="" min=""/>
        <x-input-group labelclass="" id="email" name="email" labelname="Email" class="form-control" type="email"
                       placeholder="Entrer un Email" grid="" min="" step=""/>

        <x-input-group labelclass="formation" id="formation" name="formation" labelname="formation" type="text"
                       value="{{$formation->name}}"
                       class="form-control" placeholder="Entrer le nom formation" grid="form-group mb-5" read="readonly"
                       step="" min=""/>

        <x-input-group labelclass="col-md-3" id="montant" name="montant" labelname="Montant" class="form-control"
                       read="readonly" value="{{$formation->prix}}"
                       type="number" placeholder="Entrer un montant" grid="form-group" min="0" step="0.01"/>

        <button type="submit" class="btn btn-primary">Enregistrer</button>


        <!--end Actions-->
    </x-slot>

</x-main-guest-layout>
