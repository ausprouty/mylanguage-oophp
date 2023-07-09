<?php

for ($i=0; $i < 100; $i++){
    $upgrade = new BiblePassagesUpgrade();
    if ($upgrade->bpid) {
        $upgrade->findURL();
    }
}
