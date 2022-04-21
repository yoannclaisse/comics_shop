<?php
    include './includes/config.php';
    include './includes/apiCall.php';

    // create ID in $_GET
    $id = $_GET['id'];

    // prepare pagination
    $page = empty($_GET['page']) ? 1 : $_GET['page'];

    // prepare for dynamic $url
    $limit = 20;
    $offset = ($page - 1) * $limit;

    // URL comics static and authentification
    $urlHeroComics = 'http://gateway.marvel.com/v1/public/characters/' . $id . '/comics?ts=' . $time . '&apikey=' .$apiKeyPublic. '&hash='.$hash.'&limit='.$limit.'&offset='.$offset;
    $urlHeroComicsStatic = 'http://gateway.marvel.com/v1/public/characters/' . $id . '/comics'. '&limit='.$limit.'&offset='.$offset;

    // URL hero static and authentification
    $urlHero = 'http://gateway.marvel.com/v1/public/characters/' . $id . '?ts=' . $time . '&apikey=' .$apiKeyPublic. '&hash='.$hash;
    $urlHeroStatic = 'http://gateway.marvel.com/v1/public/characters/' . $id . '&limit='.$limit.'&offset='.$offset;

    //API call URL comics
    $heroComicsCall = apiCall($urlHeroComics, $urlHeroComicsStatic);
    $heroCall = apiCall($urlHero, $urlHeroStatic);

    //API call URL hero
    $comics = $heroComicsCall->data->results;
    $nameHero = $heroCall->data->results[0]->name;

    // array empty creation
    $dataComics = [];

    // foreach for API call URL comics 
    foreach($comics as $key => $value)
    {
        $price = $value->prices[0]->price;
        $testedPrice = $price == '0' ? 'Out of Stock' : $price;

        // put info inside array
        $dataComics[] = 
        [
            'image'=> $value->thumbnail->path.'.'.$value->thumbnail->extension,
            'name' => $nameHero,
            'title' => $value->title,
            'price' => $testedPrice,
            'id'=> $value->id,
        ];
    }
    include './includes/header.php';
?>
<button type="button" onclick="getURL();">Get Page URL</button>
<!-- previous and next button -->
<!-- <div class="inline-flex"> -->
    <a href="./heroComics.php?id=<?=$id?>&page=<?=$page + 1?>" class="next fixed right-0 top-2/4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
        Next
    </a>
    <a href="./heroComics.php?id=<?=$id?>&page=<?=$page - 1?>" class="prev fixed left-0 top-2/4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
        Prev
    </a>
<!-- </div> -->

<section class="bg-white py-8">
    <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
        <nav id="store" class="w-full z-30 top-0 px-6 py-1">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                    <?=$nameHero?> comics
                </a>
                <div class="flex items-center" id="store-nav-content">
                    <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                        <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                        </svg>
                    </a>
                    <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                        <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                        </svg>
                    </a>
                </div>
            </div>
        </nav>
        <!-- CARD -->
        <?php foreach ($dataComics as $key => $value): ?>
            <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                <a href="./comic.php?id=<?=$value['id']?>">
                    <img class="hover:grow hover:shadow-lg" src="<?= $value['image'] ?>">
                    <div class="pt-3 flex flex-col items-start justify-center">
                        <p class="pt-1 text-gray-900"><?= $value['title'] ?></p>
                        <p class="pt-1 text-gray-900"><?= $value['price'] ?> $</p>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</section>
<?php include './includes/footer.php' ?>



