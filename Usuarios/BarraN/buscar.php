<?php
include("../conexion.php");

$query = isset($_GET['query']) ? $conexion->real_escape_string($_GET['query']) : '';
$resultados = [];

if (!empty($query)) {
    $sql = "SELECT id, titulo FROM noticias WHERE titulo LIKE '%$query%' OR contenido LIKE '%$query%'";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $resultados = $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<?php include("barra_de_navegacion.php"); ?>

<body>
    <div class="contenido">
        <h1>Resultados de búsqueda</h1>

        <?php if (!empty($query)): ?>
            <?php if (!empty($resultados)): ?>
                <ul>
                    <?php foreach ($resultados as $noticia): ?>
                        <li>
                            <a href="noticia.php?id=<?php echo $noticia['id']; ?>">
                                <?php echo htmlspecialchars($noticia['titulo']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No se encontraron resultados para "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Escribe algo en la barra de búsqueda.</p>
        <?php endif; ?>
    </div>
</body>