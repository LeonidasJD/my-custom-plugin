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
        add_action('admin_init', array($this, 'settings')); //ovde kreiramo funkciju koja ce izvrsiti registraciju nasih polja u bazi
    }

    function settings()
    {
        add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');
        //funkcija kojom kreiramo sekciju gde zelimo da napravimo polje
        //1.argument je naziv sekcije koji smo kreirali u funkciji ispod u 5.argumentu.
        //2.argument je naziv sekcije, obicno nam ne treba pa to postavljamo na null
        //3.argument jeste neki text koji mozemo da napisemo npr opis sta polje radi itd.
        //4.argument jeste slug koji ce da se pojavi kada dodjemo do polja ,to je isti slug koji smo prethodno kreirali

        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
        //funkcija za kreiranje registrovanog polja na frontendu tj u nasem podesavanju.
        //1.argument jeste naziv naseg polja koje smo registrovali u bazi(wcp_location)
        //2.argument jeste labela koja ce se videti na frontu
        //3.argument jeste funkcija u kojoj ce se nalaziti nas html koji kreira to polje
        //4.argument jeste slug koji ce se pokazati u URL kada udjemo u nase podesavanje (kopiramo vec koje smo izabrali u funkciji ispod)
        //5.argument jeste sekcija gde ce se nase polje naci 


        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
        //metoda za registraciju jednog podesavanja
        //1. argument jeste naziv grupi kojem ce ovo podesavanje pripasti(porizvoljan naziv)
        //2.argument jeste naziv podesavanja (proizvoljan naziv)
        //3.argument jeste podaci o polju koje kreiramo koji se salju u bazu, da li registrujemo textualno polje, polje za broj itd.



        add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));
        //drugo polje na stranici settings. Kopirali smo kod kao kod prvog polja samo menjamo ime novog polja , postavljamo ga u istu sekciju i sve 

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



    function locationHTML() //funckija koja kreirane nase prvo polje
    {
        ?>
        <select name="wcp_location">
            <option value="0" <?php get_option('wcp_location', '0') ?>>Begining of post</option>
            <!--vrednosti u options poljima su zapravo one koje smo registorvali u  register_setting() i postavili za default=0 pa samim tim i opcija sa vrednoscu 0 ce biti difoltna-->
            <option value="1" <?php get_option('wcp_location', '1') ?>>End of the post</option>
            <!--metoda get_option() nam omogucava da sacuvamo vrednosti koje smo odabrali klikom na save dugme-->
        </select><!--u atribut name stavljamo ime polja koje smo registovali u bazi znaci ime koje ce pisati u bazi a ne labelu-->
        <?php
    }

    function headlineHTML()
    {
        ?>
        <input type="text" name="wcp_headline" value=" <?php echo get_option('wcp_headline') ?>">
        <?php
    }




    function settingsHtml()
    {
        ?>
        <h1>
            Word count settings
        </h1>
        <form action="options.php" method="POST">
            <?php
            settings_fields('wordcountplugin'); //ubacujemo naziv grupe polja kojoj nase polje pripada ,grupu smo kreirali u funkciji register_setting(), ovo ce fikovati bug kada kliknemo save dugme
            do_settings_sections('word-count-settings-page'); // ubacujemo nasu sekciju koju smo kreirali unutar stranice settings koju smo prvo napravi gde ce biti sva nasa polja 
            //kao parametar prihvata slug do sekcije. A unutar sekcije smo napravili polje funkcijom add_settings_field()            
            submit_button(); //save button
            ?>
        </form>
        <?php
    }




}
//kreirali smo klasu i instancirali je , ovo smo uradili zato da bi mogli da koristimo nazive funkcija
//kako zelimo kako ne bi doslo do konflikta sa drugim pluginovima, zato nas plugin ima klasu.
$wordCountClass = new wordCount();


?>