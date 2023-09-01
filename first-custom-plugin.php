<?php
/*
Plugin Name: My custom plugin.
Description: Amazing plugin.
Version: 1.0
Author: Milan
*/


//kreiramo plugin koji ce dodati opciju u settings wp dashborda koja ce brojati reci u tekstu postova
class wordCount
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'addSettingsLink')); //admin_menu hook sluzi da doda link ka pluginu unutar Settings-a u wp dashbordu
    }

    function addSettingsLink()
    { // funkcija add_options_page postavlja naziv plugina ,dozvole ko moze da vidi i koristi plugin it
        add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'settingsHtml'));
        /*1.Argument - Naziv nase opcije za brojanje teksta
        2. Argument- Naziv onoga sto ce pisati u settingsu
        3.Argument -Permisija- ko moze da vidi ovu nasu opciju (u ovom slucaju samo admin)
        4.Argument -slug koji ce da se prikaze u URL kada otvorimo opciju
        5.Argument - Funkcija koja ce kreirati html tj interfejs koji cemo koristiti u toj opciji  */
    }

    function settingsHtml()
    {
        ?>
        <h1>
            Word count settings
        </h1>
        <?php
    }
}
//kreirali smo klasu i instancirali je , ovo smo uradili zato da bi mogli da koristimo nazive funkcija
//kako zelimo kako ne bi doslo do konflikta sa drugim pluginovima, zato nas plugin ima klasu.
$wordCountClass = new wordCount();


?>