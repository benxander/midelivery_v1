<?php echo '<?xml version="1.0" encoding="utf-8"?>' . "\n"; ?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
        <title><? echo $nombre_feed; ?></title>
        <link><? echo $url_feed; ?></link>
        <description><? echo $descripcion; ?></description>
        <dc:language><? echo $lenguaje; ?></dc:language>
        <dc:creator><? echo $autor; ?></dc:creator>
        <dc:rights>Copyright <? echo gmdate("Y", time()); ?></dc:rights>
        <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
        <? foreach ($articulos as $item): ?>
            <item>
                <title><? echo xml_convert($item['titulo']); ?></title>
                <link>
                <?	$arreglo = array(
						'inicio',
						'noticias',
                        'ver_articulo',
						strtolower(url_title($item['titulo'] . "-" . $item['id']))
					);

                echo site_url($arreglo);
                ?>
                </link>
                <guid>
                    <? echo site_url($arreglo); ?>
                </guid>
                <description>
                    <![CDATA[
                    <? echo word_limiter($item['contenido'], 100, ' [...]'); ?>
                    ]]>
                </description>
                <pubDate><?php echo gmdate(DATE_RSS, strtotime($item['fecha'])); ?></pubDate>

            </item>
        <? endforeach; ?>
    </channel>
</rss>