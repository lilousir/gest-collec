<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des commentaires des objets</h4>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover" id="tableComments">
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Reponse</th>
                <th>Commentaire</th>
                <th>Nom de l'objet</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableComments').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/comment/searchdatatable",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {
                    data : 'id_user',
                    sortable : false,
                    render : function(data, type, row) {
                        return `<a class="link-underline link-underline-opacity-0" href="${baseUrl}admin/user/${row.id_user}">${row.username}</a>`;
                    }
                },
                {"data": "id_comment_parent"},
                {"data": "content"},
                {
                    data : 'item_name',
                    sortable : false,
                    render : function(data, type, row) {
                        return `<a class="link-underline link-underline-opacity-0" href="${baseUrl}admin/item/${row.id_item}">${row.item_name}</a>`;
                    }
                },
                {"data": "created_at"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="${baseUrl}admin/comment/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
            ]
        });
    });

</script>