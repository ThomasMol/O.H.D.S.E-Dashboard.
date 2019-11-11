<?php


namespace App\Http\View;
use App\Bestuursjaar;
use Illuminate\Contracts\View\View;


class ViewComposer
{
    private $huidig_jaar;

    public function compose(View $view) {
        if(!$this->huidig_jaar){
            $this->huidig_jaar = Bestuursjaar::huidigJaar();
        }
        $view->with('huidig_jaar', $this->huidig_jaar);
    }
}
