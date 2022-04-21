const price = [...document.querySelectorAll('.price')]
const cardComics = [...document.querySelectorAll('.cardComics')]
const amount = [...document.querySelectorAll('.amount')]
const buttonCart = document.querySelector('.buttonCart')
const buttonPrev = document.querySelector('.prev')
// console.log(buttonCart);

// function getURL() {
//     alert(window.location.href);
// }

const url = window.location.href;
console.log(url);

console.log(url.match(/[0-9]+$/)[0])
if(url.match(/[0-9]+$/)[0] == 1 )
{
    buttonPrev.style.display = 'none'
}

price.forEach((element, index, array) =>
{
    console.log(element)
    if(element.innerText == '$ Out of Stock')
    {
        buttonCart.classList.add('disable')
    }
});

if(buttonCart.classList.contains('disable'))
{
    buttonCart.addEventListener('click', (event)=>
    {
        event.preventDefault()
    })
}




