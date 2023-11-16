<div class="btn-group">
    <div class="mr-1 ml-1">
        <a href="{{ route('admin.roles.edit', $id) }}" title="Editar" class="btn btn-primary btn-sm"> <i
                class="fas fa-pencil-alt"></i></a>
    </div>
    <div>
        <form action="{{ route('admin.roles.destroy', $id) }}" method="POST" id="{{$id}}"  >
            @csrf
            @method('DELETE')

            <button type="submit" title="Eliminar" class="btn btn-danger btn-sm"
            onclick="myFunction(event, {{ $id }})"><i
                    class="far fa-trash-alt"></i></button>
        </form>
    </div>
</div>


<!--

<script>
    $("#eliminar_registro").click(function(e) {
        e.preventDefault()
        Swal.fire({
            title: 'Eliminar',
            text: "¿Realmente desea eliminar el registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Elimina'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Eliminado!',
                    'Se ha eliminado el Registro Correctamente.',
                    'success'
                )
            }
        })
    });
</script>-->
