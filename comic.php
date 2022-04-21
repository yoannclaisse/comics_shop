<?php
    include './includes/config.php';
    include './includes/apiCall.php';

    $id = $_GET['id'];

    // API CALL
    $urlComic = 'http://gateway.marvel.com/v1/public/comics/' . $id . '?ts=' . $time . '&apikey=' .$apiKeyPublic. '&hash='.$hash;
    $urlComicStatic = 'http://gateway.marvel.com/v1/public/comics/' . $id;
    $comicCall = apiCall($urlComic, $urlComicStatic);

    // INITIALISATION FOR IMAGE PATH
    $path = $comicCall->data->results[0]->thumbnail->path;
    $extension = $comicCall->data->results[0]->thumbnail->extension;
    $image = $path.'.'.$extension;

    // TAKE INFO
    $title = $comicCall->data->results[0]->title;
    $pageCount = $comicCall->data->results[0]->pageCount;
    $format = $comicCall->data->results[0]->format;
    $priceDollar = $comicCall->data->results[0]->prices[0]->price;
    $price = $comicCall->data->results[0]->prices[0]->price;
    $onsaleDate = $comicCall->data->results[0]->dates[0]->date;
    $dateType = $comicCall->data->results[0]->dates[0]->type;
    $eanCode = $comicCall->data->results[0]->ean;
    $creators = $comicCall->data->results[0]->creators->items;

    // SANITIZE INFO
    $testedPrice = $priceDollar == '0' ? 'Out of Stock' : $priceDollar;
    $testedEanCode = empty($eanCode) ? '----' : $eanCode;
    $testedPageCount = $pageCount == '0' ? 'Poster' : $pageCount;
    $convertDate = date_create($onsaleDate);
    $convertedDate = date_format($convertDate, 'Y-m-d H:i:s');

    // INITIALISATION $_SESSION
    if(!empty($_POST))
    {
        if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart']))
        {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$id] = (int)$_POST['quantity'];
    }

    include './includes/header.php';
?>

<div class="bg-white">
    <div class="pt-6">
        <!-- Image gallery -->
        <div class="mt-6 max-w-2xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8">
            <div class="aspect-w-4 aspect-h-5 sm:rounded-lg sm:overflow-hidden lg:aspect-w-3 lg:aspect-h-4">
                <img src="<?=$image?>" alt="Model wearing plain white basic tee." class="w-full h-full object-center object-cover">
            </div>
        </div>

        <!-- Product info -->
        <div class="max-w-2xl mx-auto pt-10 pb-16 px-4 sm:px-6 lg:max-w-7xl lg:pt-16 lg:pb-24 lg:px-8 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
            <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl"><?=$title?></h1>
            </div>

            <!-- Options -->
            <div class="mt-4 lg:mt-0 lg:row-span-3">
                <p class="price text-3xl text-gray-900">$ <?=$testedPrice?></p>
                <form class="mt-10" action="#" method="post">
                    <button type="submit" class="buttonCart mt-10 mb-10 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add to bag</button>
                    <div class="counterDiv">
                        <label class="text-black for="quantity">Quantity :</label>
                        <input class="text-black counter" type="number" id="quantity" name="quantity" min="1" max="100" value="1">
                    </div>
                </form>
            </div>
            <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                <!-- HIGHLIGHTS -->
                <div class="mt-10">
                    <h3 class="text-sm font-medium text-gray-900">Informations</h3>
                    <div class="mt-4">
                        <ul role="list" class="pl-4 list-disc text-sm space-y-2">
                            <li class="text-gray-400"><span class="text-gray-600"><?=$dateType.': '.$convertedDate?></span></li>
                            <li class="text-gray-400"><span class="text-gray-600">Format: <?=$format?></span></li>
                            <li class="text-gray-400"><span class="text-gray-600">Pages: <?=$testedPageCount?></span></li>
                            <li class="text-gray-400"><span class="text-gray-600">EAN Code: <?=$testedEanCode?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>