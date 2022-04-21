<?php
    include './includes/config.php';
    include './includes/apiCall.php';

    // FUNCTION TO CALCULATE PRICE
    function calculatePrice($quantity, $price)
    {
        if(is_numeric($quantity) && is_numeric($price))
        {
            $calculatedPrice = $price * $quantity;
            return round($calculatedPrice, 2);
        }
    }

    // TESTED ARRAY
    if (isset($_POST['moreArticle']))
    {
        $_SESSION['cart'][$_POST['id']]++;
    }

    if (isset($_POST['lessArticle']))
    {
        $_SESSION['cart'][$_POST['id']]--;
        
        if($_SESSION['cart'][$_POST['id']] <= 0)
        {
            $_SESSION['cart'][$_POST['id']] = 0;
        }
    }

    $comics =[];
    $articlesPricesArray = [];

    // INITIALISATION OF $_SESSION
    foreach($_SESSION['cart'] as $id => $quantity)
    {
        $urlComic = 'http://gateway.marvel.com/v1/public/comics/' . $id . '?ts=' . $time . '&apikey=' .$apiKeyPublic. '&hash='.$hash;
        $urlComicStatic = 'http://gateway.marvel.com/v1/public/comics/' . $id;
        $comicCall = apiCall($urlComic, $urlComicStatic);

        $path = $comicCall->data->results[0]->thumbnail->path;
        $extension = $comicCall->data->results[0]->thumbnail->extension;
        $image = $path.'.'.$extension;

        $comic =[];
        $comic['image'] = $image;
        $comic['title'] = $comicCall->data->results[0]->title;
        $comic['pageCount'] = $comicCall->data->results[0]->pageCount;
        $comic['format'] = $comicCall->data->results[0]->format;
        $comic['price'] = $comicCall->data->results[0]->prices[0]->price;
        $comic['ean'] = $comicCall->data->results[0]->ean;
        $comic['quantityOrdered'] = $quantity;
        $comic['id'] = $id;
        $comic['finalprice'] = calculatePrice($comic['quantityOrdered'], $comic['price']);
        $articlesPricesArray[] = $comic['finalprice'];

        $comics[] = $comic;
    }

    // STOCK IN VARIABLE THE SUM OF ARRAY
    $sumArticlesPrices = array_sum($articlesPricesArray);

    include './includes/header.php';
?>

<div class="w-full bg-gray-300 flex justify-center items-center">
    <div class="w-11/12">
        <div class=" bg-gray-100 shadow-lg rounded-lg ">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="md:grid md:grid-cols-3 gap-2 ">
                        <div class="col-span-3 p-5">
                            <h1 class="text-xl text-black font-medium ">Shopping Cart</h1>
                            <?php foreach ($comics as $key => $comic):?>
                                <div class="flex justify-between items-center mt-6">
                                    <div class="flex items-center w-1/6"> <img src="<?=$comic['image']?>" width="60"></div>
                                    <div class="flex flex-col ml-3 w-1/6"> <span class="md:text-md text-black font-medium"><?=$comic['title']?></span> <span class="text-xs font-light text-gray-400">#<?=$comic['id']?></span> </div>
                                    <form action="#" method="post" class="w-1/6">
                                        <fieldset>
                                            <label class="text-black" for="unitPrice">Unit Price:</label>
                                            <div class="text-black">$ <?=$comic['price']?></div>
                                        </fieldset>
                                    </form>
                                    <form action="#" method="post" class="w-1/6">
                                        <label class="text-black for="quantityOrdered:">Quantity ordered:</label>
                                        <fieldset class="quantityOrdered flex">
                                            <input class="lessArticle bg-gray-300 text-black" type="submit" name="lessArticle" value="-"/>
                                            <input type="hidden" name="id" value="<?=$comic['id']?>"/>
                                            <div class="quantity flex justify-center items-center text-black"><?=$comic['quantityOrdered']?></div>
                                            <input class="moreArticle bg-gray-300 text-black" type="submit" name="moreArticle" value="+"/>
                                            <input type="hidden" name="id" value="<?=$comic['id']?>"/>
                                        </fieldset>
                                    </form>
                                    <div class="prices w-1/6 text-black">$ <?= calculatePrice($comic['quantityOrdered'], $comic['price']) ?></div>
                                    <a class="button w-1/6 text-black" href="./clearCart.php?id=<?=$comic['id']?>"> <img src="./assets/images/trash.png" alt="trash" width="16px"> </a>
                                </div>
                            <?php endforeach ?>
                            <div class="flex justify-between items-center mt-6 pt-6 border-t">
                                <a href="#" class="flex items-center"> <i class="fa fa-arrow-left text-sm pr-2"></i> <span class="text-md font-medium text-blue-500">Continue Shopping</span> </a href="#">
                                <div class="flex justify-center items-end"> <span class="text-sm font-medium text-gray-400 mr-1">Subtotal:</span> <span class="text-lg font-bold text-gray-800 ">$ <?=$sumArticlesPrices == 0 ? 'You have nothing on your Cart' : $sumArticlesPrices?></span> </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>