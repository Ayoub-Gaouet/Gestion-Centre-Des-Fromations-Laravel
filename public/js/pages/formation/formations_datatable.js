[
    {data: 'id', name: 'id'},
    {data: 'name', name: 'name'},
    {data: 'description', name: 'description'},
    {data: 'date_debut', name: 'date_debut'},
    {data: 'date_fin', name: 'date_fin'},
    {data: 'duree', name: 'duree'},
    {data: 'lieu', name: 'lieu'},
    {data: 'prix', name: 'prix'},
    {data: 'is_terminated', name: 'is_terminated'},
    {data: 'max_places', name: 'max_places'},
    {
        data: 'formateur_id', name: 'formateur_id', render: function (data, type, full, meta) {
            return full.formateur.name;

        }
    },
    {data: 'created_at', name: 'created_at', searchable: false},
    {data: 'updated_at', name: 'updated_at', searchable: false},
    {data: 'action', name: 'action', orderable: false, searchable: false},
]
