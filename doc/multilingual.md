# Multilingual behavior extension for Doctrine 2


    $article = new Entity\Article;
    $article->setTitle('my title in en');
    $article->setContent('my content in en');
    $em->persist($article);
    $em->flush();

    $article->multilingual('ru_RU')->setTitle('Title in Russian');
    $article->multilingual('ru_RU')->setContent('Content in Russian');

