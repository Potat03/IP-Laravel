<!--Nicholas Yap Jia Wey-->
<?php

namespace App\Memento;

use App\Memento\PromotionMemento;
class PromotionCaretaker {

    private $promotionMementoList = [];

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['promotionMementoList'])) {
            $this->promotionMementoList = $_SESSION['promotionMementoList'];
        }
    }

    public function addMemento(PromotionMemento $memento) {
        $this->promotionMementoList[] = $memento;
        $_SESSION['promotionMementoList'] = $this->promotionMementoList;
    }

    public function getMemento($index) {
        $memento = $this->promotionMementoList[$index];
        unset($this->promotionMementoList[$index]);
        $_SESSION['promotionMementoList'] = $this->promotionMementoList;
        return $memento;
    }

    public function getMementoList() {
        return $this->promotionMementoList;
    }

    public function clearMementoList() {
        $this->promotionMementoList = [];
        $_SESSION['promotionMementoList'] = $this->promotionMementoList;
    }
}
