
<?

function ziffernZuBuchstaben($input) {
          $output = '';
          $zuordnung = ['1' => 'A) ', '2' => 'B) ', '3' => 'C) ', '4' => 'D) ', '5' => 'E) '];
      
          for ($i = 0; $i < strlen($input); $i++) {
              $ziffer = $input[$i];
              // Überprüfen, ob die Ziffer zwischen 1 und 5 liegt
              if (isset($zuordnung[$ziffer])) {
                  $output .= $zuordnung[$ziffer];
              } else {
                  // Falls eine Ziffer außerhalb des Bereichs von 1-5 gefunden wird, gebe einen Fehler oder eine Meldung zurück
                  $output .= "(Fehler: Ungültige Ziffer '$ziffer')";
              }
          }
      
          return $output;
      }
      