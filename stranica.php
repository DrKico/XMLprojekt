<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['naziv']) && !empty($_POST['naziv'])) {
    $uneseniNaziv = strtolower($_POST['naziv']);

    $xml = simplexml_load_file('podatci.xml');

    $rezultati = $xml->xpath("//film[contains(translate(naziv, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '$uneseniNaziv')]");

    if (!empty($rezultati)) {

      foreach ($rezultati as $rezultat) {
        $naziv = (string) $rezultat->naziv;
        $zanr = (string) $rezultat->zanr;
        $godina = (string) $rezultat->godina;

        echo "Film: $naziv<br>";
        echo "Žanr: $zanr<br>";
        echo "Godina: $godina<br>";
      }
    } else {
      echo "Film s nazivom '$uneseniNaziv' nije pronađen.";
    }
  }

  if (isset($_POST['naziv']) && isset($_POST['zanr']) && isset($_POST['godina'])) {
    $noviFilm = [
      'naziv' => $_POST['naziv'],
      'zanr' => $_POST['zanr'],
      'godina' => $_POST['godina']
    ];

    $xml = simplexml_load_file('podatci.xml');

    $film = $xml->addChild('film');
    $film->addChild('naziv', $noviFilm['naziv']);
    $film->addChild('zanr', $noviFilm['zanr']);
    $film->addChild('godina', $noviFilm['godina']);

    // Spremanje promjena u XML datoteku
    $xml->asXML('podatci.xml');

    echo "Novi film je uspješno dodan u XML datoteku.";
  }
}
?>
