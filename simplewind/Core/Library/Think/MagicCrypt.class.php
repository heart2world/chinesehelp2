<?php
namespace Think;
class MagicCrypt {
    
     protected $cipher = MCRYPT_RIJNDAEL_128;
    protected $mode = MCRYPT_MODE_ECB;
    protected $pad_method = NULL;
    protected $secret_key = '';
    protected $iv = '';
    
    public function set_cipher($cipher) {
        $this->cipher = $cipher;
    }
    
    public function set_mode($mode) {
        $this->mode = $mode;
    }
    
    public function set_iv($iv) {
        $this->iv = $iv;
    }
    
    public function set_key($key) {
        $this->secret_key = $key;
    }
    
    public function pad($text) {
        $blocksize = mcrypt_get_block_size ( $this->cipher, $this->mode );
        $pad = $blocksize - (strlen ( $text ) % $blocksize);
        return $text . str_repeat ( chr ( $pad ), $pad );
    }
    
    protected function unpad($text) {
        
        $pad = ord ( $text {strlen ( $text ) - 1} );
        if ($pad > strlen ( $text )) {
            return false;
        }
        if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad) {
            return false;
        }
        return substr ( $text, 0, - 1 * $pad );
    }
    
    public function encrypt($str) {
        $str = $this->pad ( $str );
        $td = mcrypt_module_open ( $this->cipher, '', $this->mode, '' );
        
        if (empty ( $this->iv )) {
            $iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
        } else {
            $iv = $this->iv;
        }
        
        mcrypt_generic_init ( $td, $this->secret_key, $iv );
        $cyper_text = mcrypt_generic ( $td, $str );
        mcrypt_generic_deinit ( $td );
        mcrypt_module_close ( $td );
        return $cyper_text;
    }
    
    public function decrypt($str) {
        $td = mcrypt_module_open ( $this->cipher, '', $this->mode, '' );
        
        if (empty ( $this->iv )) {
            $iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
        } else {
            $iv = $this->iv;
        }
        mcrypt_generic_init ( $td, $this->secret_key, $iv );
        $decrypted_text = mdecrypt_generic ( $td, $str );
        $rt = $decrypted_text;
        mcrypt_generic_deinit ( $td );
        mcrypt_module_close ( $td );
        return $this->unpad ( $decrypted_text );
    }
    
  
    
    public function generate_text($str) {
        $str = $this->encrypt ( $str );
        return base64_encode ( $str );
    }


     public function generate_textdecode($str) {
        $str = $this->decrypt ( $str );
        return base64_decode ( $str );
    }
}

?>