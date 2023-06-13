<?php



abstract class BiblePassageController
{

    private $bibleReferenceInfo;
    private $bible;
    public  $bibleText;
    public  $passageLink;

    public abstract function __construct();
    public abstract function checkDatabase();
    public abstract function getExternal();
    public abstract function formatExternal();
    public abstract function saveExternal();


}