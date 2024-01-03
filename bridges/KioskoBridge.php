<?php

class KioskoBridge extends BridgeAbstract
{
    const NAME = 'Kiosko';
    const URI = 'https://es.kiosko.net/';
    const DESCRIPTION = 'Returns the newspaper cover of the day on Kiosko';
    const MAINTAINER = 'ariedro';

    const PARAMETERS = [
        [
            'path' => [
                'name' => 'path',
                'required' => true,
                'title' => 'Path for the newspaper',
                'exampleValue' => 'ar/np/ar_clarin.html'
            ]
        ]
    ];

    public function collectData()
    {
        $path = $this->getInput('path');
        $html = getSimpleHTMLDOM(self::URI . $path);

        $fecha = $html->find('#menuFecha')[0]->innertext;
        $portada = $html->find('#portada')[0]->src;

        $diario_uri = $html->find('.frontPageImage a')[0]->href;
        $diario = $html->find('.titPaper')[0]->innertext;

        $item = [];

        $item['uri'] = $this->getURI();
        $item['title'] = $diario . ' - ' . $fecha;
        $item['content'] = '<a href="' . $diario_uri . '" > <img src="https:' . $portada . '" /> </a>';

        $this->items[] = $item;
    }
}
