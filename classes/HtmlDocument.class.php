<?php
/**
 * Moteur de template simple.
 *
 * Les pages doivent être stockées dans le répertoire pages/ et porter l'extension '.inc.php'. Une page peut retourner l'exception NotConnectedException si elle requière la connexion de l'utilisateur pour être affichée.
 * Les templates doivent être stockées dans le répertoire templates/. Ce sont des répertoires qui portent le nom du template et doivent contenir le fichier 'template.php' (ainsi que les éventuelles ressources liées au template: images, etc...)
 *
 * Utilisation basique :
 *   $doc = new HtmlDocument('mapage') ;
 *   $doc->applyTemplate('defaut') ;
 *   $doc->render() ;
 */
class HtmlDocument {
    static private $currentInstance;

    protected $mainFilePath;
    protected $templateName;
    protected $headers;
    protected $mainContent;
    protected $bodyContent;

    public function __construct($mainFile){

        //$this = l'objet que je suis en train de créer
        if(HtmlDocument::$currentInstance !== null) throw new Exception("CurrentInstance non nulle");
        else HtmlDocument::$currentInstance = $this;

        //body et main représentent du code html
        $this->bodyContent = null;
        $this->mainContent = null;

        //balise head de la page (1 ligne du tableau représente 1 balise)
        $this->headers = array();
        $this->templateName = null;

        //vérification de sécurité (pas de caractères spéciaux permettant de remonter dans l'arborescence) + vérification
        //pour savoir si la page existe 
        $this->mainFilePath = ROOT_PATH  .'/pages/' .$mainFile.".main.php";
        if(strpbrk($mainFile, ".<>!:") !== false || !file_exists($this->mainFilePath)) $this->mainFilePath = 'pages/pageErreur.main.php';
        $this->parseMain();
    }

    protected function parseMain(){
        ob_start();
        include $this->mainFilePath;
        $this->mainContent = ob_get_clean();
    }
    protected function parseTemplate(){
        ob_start();
        include $this->templateName . "/template.php";
        $this->bodyContent = ob_get_clean();
    }
    public function applyTemplate($templateName){
        $this->templateName = "templates/".$templateName  ;
        $this->parseTemplate() ;
    }
    public function render(){
        echo($this->bodyContent);
    }
    public function getMainContent(){
        return $this->mainContent;
    }
    public function addHeader($html){
        $html = (explode(",", $html));
        foreach ($html as $element) {
            array_push($this->headers, $element);
            echo($element);
        }
    }

    public static function getCurrentInstance(){
        return HtmlDocument::$currentInstance;
    }

}
