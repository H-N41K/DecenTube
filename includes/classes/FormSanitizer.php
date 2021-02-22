<?php
class FormSanitizer {
    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = trim($inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
     }

     public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
     }

     public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
     }

     public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
     }

     public static function sanitizeEthAddress($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
     }

     public static function sanitizeUrl($inputText) {
      $inputText = trim($inputText);
      return filter_var($inputText, FILTER_SANITIZE_URL);
   }

   public static function sanitizeBlockiesIcon($inputText) {
      $inputText = trim($inputText);
      return $inputText;
   }


}
?>