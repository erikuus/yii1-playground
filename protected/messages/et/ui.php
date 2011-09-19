<?php
/**
 * User Interface Messages.
 *
 * Each array element represents the translation (value) of a message (key).
 * If the value is empty, the message is considered as not translated.
 * Messages that no longer need translation will have their translations
 * enclosed between a pair of '@@' marks.
 *
 * NOTE, this file must be saved in UTF-8 encoding.
 *
 * @version $Id: $
 */
return array (
// view specific
	// misc
	'View code'=>'Vaata koodi',
	'Browse code'=>'Vaata lisaks',
	'Explain code'=>'Selgitav info',
    'Read more'=>'Täpsem info',
	'Bookmark'=>'Pane järjehoidjasse',
	'NB! Access restricted by IP'=>'NB! Toimib ainult sisevõrgus',
	'Please do not send message from here!'=>'Palun tagasisidet siit mitte saata!',
	'Configuration' => 'Konfiguratsioon',
	'Imported functions' => 'Import funktsionaalsus',
	'from' => 'alates',
	'to' => 'kuni',
	// persons
	'Persons' => 'Isikud',
	'List Person' => 'Sirvi isikuid - List view',
	'New Person' => 'Uus isik',
    'Update Person' => 'Muuda isikut',
    'Manage Persons' => 'Halda isikuid - Grid view',
    'View Person' => 'Vaata isikut - Detail view',
	'Make selected persons 1 year older' => 'Tee valitud isikud 1 aasta vanemaks ',
	'Make selected persons 1 year younger' => 'Tee valitud isikud 1 aasta nooremaks',
	// autocomplete widget
	'Country'=>'Riik',
	'Countries'=>'Riigid',
	'These fields will be filled automatically after you select country'=>'Need väljad täidetakse automaatselt, kui valid riigi',
	// multiple file upload
	'Upload'=>'Lae üles',
	// map input
	'Clear map' => 'Puhasta kaart',
	'Click on the map to place markers. Then drag the markers to define a polygon.' => 'Klõpsi kaardil, haara hiirega punasest ruudust kinni ja lohista.',
	// wizard
	'Wizard was cancel'=>'Vormi täitmine katkestati',
	'Start over again'=>'Alusta otsast peale',
	// user
	'State Archive'=>'Riigiarhiiv',
	'Historical Archive'=>'Ajalooarhiiv',
	'Site Manager'=>'Haldur',
	'User Manager'=>'Kasutajate haldur',
	'Content Manager'=>'Sisuhaldur',
// model specific
	//persons
	'Firstname'=>'Eesnimi',
	'Lastname'=>'Perenimi',
	'Birth'=>'Sünd',
	'Webpage'=>'Veebileht',
	'Registered'=>'Registreerunud',
	'Eyecolor'=>'Silmade värv',
	//dummy
	'Gender' => 'Sugu',
	'Language' => 'Keel',
	'Estonian' => 'Eesti keel',
	'English' => 'Inglise keel',
	'German' => 'Saksa keel',
	'Russian' => 'Vene keel',
	'Spanish' => 'Hispaania keel',
	'Finnish' => 'Soome keel',
// validation specific

// flash standard
	'Thank you for contacting us. We will respond to you as soon as possible.' => 'Täname Teid tagasiside eest. Vastame Teile esimesel võimalusel.',
    'Data successfully saved!' => 'Andmed salvestatud!',
    'Data successfully deleted!' => 'Andmed kustutatud!',
// view standard
    'Home' => 'Avaleht',
    'Search' => 'Otsi',
	'Advanced Search' => 'Täpsem otsing',
	'Login' => 'Sisene',
	'Logout' => 'Välju',
    'Submit' => 'Saada',
    'Cancel' => 'Loobu',
	'Confirm' => 'Kinnita',
    'Clear' => 'Puhasta',
    'Remove' => 'Eemalda',
    'Refresh' => 'Värskenda',
    'Save' => 'Salvesta muudatused',
	'Create' => 'Salvesta',
	'Print' => 'Prindi',
	'Back' => 'Tagasi',
	'Help' => 'Abi',
    'All' => 'Kõik',
	'List' => 'Sirvi',
	'New' => 'Lisa',
    'Update' => 'Muuda',
    'Delete' => 'Kustuta',
    'Manage' => 'Halda',
    'Show' => 'Vaata',
    'Actions' => 'Toimingud',
    'Move up' => 'Liiguta üles',
    'Move down' => 'Liiguta alla',
    'Select form calendar' => 'Vali kalendrist',
	'Collapse All' => 'Sulge puu',
	'Expand All' => 'Ava puu',
    'Yes' => 'Jah',
    'No' => 'Ei',
    'Next >' => 'Järgmine >',
    '< Previous' => '< Eelmine',
	'-add-' => '-lisa-',
	'-empty-' => '-puudub-',
    '-select-' => '-valimata-',
	'Are you sure to delete this item?' => 'Kas olete kindel, et soovite kustutada selle rea?',
    'Are you sure to delete {item}?' => 'Kas olete kindel, et soovite kustutada {item}?',
	'Fields with {mark} are required' => '{mark}-ga märgitud väljad on kohustuslikud',
	'Search Results' => 'Otsingu tulemused',
	'Search results for "{query}"' => 'Otsingu "{query}" tulemused',
	'n==0#|n==1#The search returned 1 result|n>1#The search returned {c} results' => 'n==0#|n==1#Leiti 1 sobiv vaste|n>1#Leiti {c} sobivat vastet',
	'You may optionally enter a comparison operator {operators} at the beginning of each of your search values'=>'Soovi korral võid lisada võrdlusmärgi iga otsisõna ette: {operators}',
	'Are you sure to perform this action on checked items?' => 'Kas olete kindel, et soovite rakendada seda käsku märgitud ridadele?',
	'Please check items you would like to perform this action on!' => 'Palun märgista read, millele soovite rakendada seda käsku!',
	'Bookmark this page to VAU linkbook' => 'Lisa lehekülg VAU lingimärkmikku',
	'Open VAU linkbook' => 'Ava VAU lingimärkmik',
	'FAQ and Feedback' => 'KKK ja tagasiside',
// view errors
    'Page Not Found' => 'Lehekülge ei leitud',
    'Please make sure you entered a correct URL.' =>'Palun kontrolli aadressi korrektsust.',
	'Access denied' => 'Juurdepääs keelatud',
	'You are not allowed to perform this action.' => 'Sul pole lubatud seda tegevust sooritada.',
	'Bad Request' => 'Vigane päring',
	'Please do not repeat the request without modifications.' => 'Palun ära korda seda päringut.',
	'Unauthorized' => 'Autoriseerimata',
	'You do not have the proper credential to access this page.' => 'Sul ei ole piisavalt õigusi sellele leheküljele sisenemiseks.',
	'Internal Server Error' => 'Serveri viga',
	'An internal error occurred while the Web server was processing your request.' => 'Ilmnes serveri sisemine viga.',
	'Service Unavailable' => 'Teenus pole saadaval',
	'Our system is currently under maintenance. Please come back later.' => 'Meie süsteem on hooldustöödeks suletud. Proovi varsti uuesti.',
	'If you think this is a server error, please contact'=> 'Kui Sa arvad, et see on programmi viga, palun võta ühendust',
	'Please contact' => 'Palun võta ühendust',
	'Contact for more information' => 'Kui soovid rohkem informatsiooni, palun võta ühendust',
	'Return to homepage'=> 'Pöördu tagasi avalehele',
// model standard
    'Username' => 'Kasutajanimi',
    'Password' => 'Salasõna',
	'Repeat password' => 'Korda salasõna',
	'Change password' => 'Muuda salasõna',
	'Remember me next time' => 'Jäta mind meelde',
	'Username is incorrect' => 'Vale kasutajanimi',
	'Password is incorrect' => 'Vale salasõna',
	'Contact' => 'Tagasiside',
    'Name' => 'Nimi',
    'Email' => 'E-post',
	'Subject' => 'Pealkiri',
	'Body' => 'Sisu',
	'Verification Code' => 'Turvakood',
    'Please enter the letters as they are shown in the image above.' => 'Palun kirjutage turvakood kõrvalolevasse kasti.',
    'If you have questions, please fill out the following form to contact us. Thank you.' => 'Selle vormi kaudu saate teatada süsteemist leitud vigadest, kasutamisel ilmnenud probleemidest, ettepanekutest jmt. Oleme tänulikud igasuguse tagasiside eest!',
// module standard
    'Classificators' => 'Klassifikaatorid',
    'Helps' => 'Abitekstid',
	'My Account' => 'Minu konto',
	'Users' => 'Kasutajad',
	'Admin Units' => 'Haldusüksused',
);
?>