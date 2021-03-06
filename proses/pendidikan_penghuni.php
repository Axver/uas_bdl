<?php
include("connect.php");
$nama_pendidikan=$_GET['nama_pendidikan'];
$sql = "SELECT gid_bangunan, air_pam, bangunan.id_pemilik_b, bangunan.id_penghuni_b, kapasitas_listrik, pbb, ST_AsGEOJSON(geom) as geometry
FROM public.bangunan INNER JOIN penghuni_bangunan ON bangunan.id_penghuni_b=penghuni_bangunan.id_penghuni_b
INNER JOIN penduduk ON penduduk.id_penduduk=penghuni_bangunan.id_penduduk WHERE penduduk.pendidikan='$nama_pendidikan'";
$result = pg_query($sql);
$hasil = array(
	'type'	=> 'FeatureCollection',
	'features' => array()
	);

while ($isinya = pg_fetch_assoc($result)) {
	$features = array(
		'type' => 'Feature',
		'geometry' => json_decode($isinya['geometry']),
		'properties' => array(
			'gid_bangunan' => $isinya['gid_bangunan']
			)
		);
	array_push($hasil['features'], $features);
}
echo json_encode($hasil);
?>