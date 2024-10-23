<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Types d'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="/admin/item/createtype" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un type</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du type</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Type parent</label>
                    <select class="form-select" name="id_type_parent">

                        <?php foreach ($all_types as $type) { ?>
                            <option value="<?= $type['id']; ?>">
                                <?= $type['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Liste des types</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableTypes">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parent</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Modif.</th>
                        <th>Supp.</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalType">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier mon type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col">
            <div class="card-body">
                 <div class="row">
            <label class="form-label">Nom du type :</label>
            <form method="POST" action="<?= base_url('/admin/item/updatetype'); ?>" id="formModal">

                    <input type="hidden" name="id" value="">
                    <input type="text" name="name" class="form-control">

                    <label class="form-label">Type parente</label>
                    <select class="form-select" name="id_type_parent">

                        <?php foreach ($all_types as $type) { ?>
                            <option value="<?= $type['id']; ?>">
                                <?= $type['name']; ?>
                            </option>
                        <?php } ?>
                    </select>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-primary" value="Valider">
                </div>

            </form>
            </div>
             </div>
        </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const modalType = new bootstrap.Modal('#modalType');
        var dataTable = $('#tableTypes').DataTable({
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax" : {
                "url" : "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type" : "POST",
                "data" : { 'model' : 'ItemTypeModel'}

            },
            "columns": [
                {"data": "id"},
                {
                    data : 'id_type_parent',
                    render : function(data) {
                        if (data == null) {
                            return `<span class='id-type-parent'></span>`;
                        } else {
                            return `<span class='id-type-parent'>${data}</span>`;
                        }
                    }
                },
                {
                    data : 'name',
                    render : function(data) {
                        return `<span class='name-type'>${data}</span>`;
                    }
                },
                {
                    data : 'slug',
                    render : function(data) {
                        return `<span class='slug-type'>${data}</span>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-type-update" id="${data}" href="<?= base_url('/admin/item/updatetype/');?>${data}"><i class="fa-solid fa-pencil text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-brand" id="${data}" href="<?= base_url('/admin/item/deletetype/');?>${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
                    }
                }
            ]
        });
        $("body").on('click', '.swal2-type', function(event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr('href');
            let id = $(this).attr("id");
            if (id == 1) {
                Swal.fire("On ne peut pas supprimer \"non classe\" !");
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('/admin/item/totalitembytype'); ?>",
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        let title = "Supprimer un type"
                        let text = `Ce type est attribuée à <b class="text-danger">${json.total}</b> objets.
                        Êtes-vous sûr de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
        $("body").on('click', '.swal2-type-update', function(event) {
            event.preventDefault();
            modalType.show();
            let id_type = $(this).attr('id');
            let name = $(this).closest('tr').find(".name-type").html();
            $('.modal input[name="id"]').val(id_type);
            $('.modal input[name="name"]').val(name);
        });
        $("#formModal").on('submit', function(event) {
            event.preventDefault();
            let id_type = $('.modal input[name="id"]').val();
            let name_type = $('.modal input[name="name"]').val();
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data : {
                    id : id_type,
                    name : name_type
                },
                success: function (data) {
                    //je transforme mon contenu pour l'utiliser en javascript
                    var json = JSON.parse(data);
                    //déclaration de ma ligne pour l'utiliser plusieurs fois
                    const ligne = $('#'+id_type).closest('tr');
                    //modification des differents champs
                    ligne.find('.slug-type').html(json.slug);
                    ligne.find('.name-type').html(json.name);
                    ligne.find('.id-type-parent').html(json.id_type_parent);
                    //fermeture de la modal
                    modalType.hide();
                }
            });
        });
    })
</script>