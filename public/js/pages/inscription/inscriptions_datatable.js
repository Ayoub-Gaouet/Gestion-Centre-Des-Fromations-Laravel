[
    {data: 'id', name: 'id'},
    {data: 'date_inscription', name: 'date_inscription'},
    {data: 'montant', name: 'montant'},
    {data: 'etat', name: 'etat'},
    {data: 'eval', name: 'eval'},
    {data: 'date_eval', name: 'date_eval'},
    {data: 'commentaire', name: 'commentaire'},
    {
        data: 'formation_id', name: 'formation_id', render: function (data, type, full, meta) {
            return full.formation.name;

        }
    },
    {
        data: 'client_id', name: 'client_id', render: function (data, type, full, meta) {
            return full.client.name;

        }
    },
    {data: 'created_at', name: 'created_at', searchable: false},
    {data: 'updated_at', name: 'updated_at', searchable: false},
    {data: 'action', name: 'action', orderable: false, searchable: false},
]
