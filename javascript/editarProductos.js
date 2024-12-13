const editarProducto = async (id) => {
    try{
        const response = await fetch("productos/productosById.php?id=" + id);
        const json = await response.json();
        return json;
    }catch(error){
        console.error("Hubo un error al intentar obtener el producto por id.")
        return false;
    }
}


const getCategorias = async (select, categoria_id) => {
    try {

        const response = await fetch("productos/categorias/categorias.php");
        const json = await response.json();

        const categoria = await getCategoriaById(categoria_id)
        if (categoria) {
            select.add(new Option(categoria.nombre, categoria.id));
            for (let i = 0; i < json.length; i++) {
                if (categoria_id != json[i].id) {

                    const nuevaOpcion = new Option(json[i].nombre, json[i].id);
                    select.add(nuevaOpcion);
                }
            }
            return json;
        }
    } catch (error) {
        console.error("Hubo un error al intentar obtenter las categorías", error);
        return false;
    }
}


const getCategoriaById = async (id) => {
    try {
        const response = await fetch("productos/categorias/categoriaById.php?id=" + id)
        const json = await response.json();
        console.log(json);
        return json;
    } catch (error) {
        console.error("Hubo un error al intenter obtener la categoría por id", error);
        return false;
    }
}
