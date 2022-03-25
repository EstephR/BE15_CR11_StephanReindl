// Initialize Swiper Slider
var swiper = new Swiper(".mySwiper", {
    speed: 600,
    parallax: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

// Initialize Interface for Class Animals
interface animals {
    name: string;
    gender: string;
    size: string;
    age: number;
    vaccine: boolean;
    img: string;
}

//Create Array which will hold the later created objects
let arrAnimals: Array<Animal> = [];

//create main class Animal
class Animal implements animals {
    constructor(public name: string, public gender: string, public size: string, public age: number, public vaccine: boolean, public img: string) {
        arrAnimals.push(this);
    }

    displayStart() {
        return `<div class="card border-0 shadow p-0" style="width: 18rem;">
        <img src="${this.img}" class="card-img-top d-xl-block d-lg-block d-md-block d-sm-none" height="500" style="object-fit:cover; object-position:center" alt="${this.name}, ${this.gender}, ${this.size}, ${this.age}">
        <div class="card-header text-center text-light h4">${this.name}</div>
        <div class="card-body">
            <p class="card-text m-0">Gender: ${this.gender}</p>
            <p class="card-text m-0">Age: ${this.age}</p>
            <p class="card-text m-0">Size: ${this.size}</p>
            <div class="vaccine-container d-flex justify-content-center align-items-center p-2 rounded-pill mt-3 mb-3">
                <div class="vaccine-text text-light me-2">Vaccine</div>
                <img class="vaccine-icon" src="...">
            </div>`
    }

    displayEnd() {
        return `</div>
        </div>`
    }

    displayFull() {
        return this.displayStart() + this.displayEnd();
    }
}

//Create Objects out of class Animals
new Animal("Vincent Van Goat", "male", "medium", 8, true, "img/vincentVanGoat.jpg");
new Animal("Patrick Lazyee", "male", "medium", 12, false, "img/patrickLayze.jpg");
new Animal("Michael J. Fox", "male", "small", 5, true, "img/michaelJFox.jpg");
new Animal("El Duderrhino", "male", "big", 25, false, "img/elDuderhino.jpg");

//Create Extended class Cat
class Cat extends Animal {
    constructor (name: string, gender: string, size: string, age: number, vaccine: boolean, img: string, public breed: string, public furColor: string, public breedInformation: string, public breedName: string) {
        super (name, gender, size, age, vaccine, img)
    }
    displayFull() {
        return `${super.displayStart()} 
        <p class="card-text m-0">Breed: ${this.breed}</p>
        <p class="card-text m-0">Fur Color: ${this.furColor}</p> 
        <p class="card-text m-0">Breed Info: <a href="${this.breedInformation}">${this.breedName}</a></p> 
        ${super.displayEnd()}`  
    }
}

//Create Objects out of class Cat
new Cat("Cleocatra", "female", "small", 3, true, "img/cleocatra.jpg","Sphynx", "white", "https://en.wikipedia.org/wiki/Sphynx_cat", "Sphynx Cat");
new Cat("Furrnando Cortez", "male", "small", 6, false, "img/furrnandoCortez.jpg","Brasilian Shorthair", "white", "https://en.wikipedia.org/wiki/Brazilian_Shorthair", "Brasilian Shorthair");
new Cat("Space Cat-et", "female", "small", 4, true, "img/spacecatet2.jpg","Astronaut", "grey", "https://en.wikipedia.org/wiki/F%C3%A9licette", "Space Cat");


class Dog extends Animal {
    constructor (name: string, gender: string, size: string, age: number, vaccine: boolean, img: string, public breed: string, public training: string) {
        super (name, gender, size, age, vaccine, img)
    }
    displayFull() {
        return `${super.displayStart()} 
        <p class="card-text m-0">Breed: ${this.breed}</p>
        <p class="card-text m-0">Training: ${this.training}</p> 
        ${super.displayEnd()}`  
    }
}

//Create Objects out of class Dog
new Dog("Sherlock Bones", "male", "big", 13, true, "img/sherlockBones.jpg","Giant Poodle", "Yes");
new Dog("Lord Thunderwoof", "male", "small", 7, false, "img/lordThunderwoof.jpg","Pug", "No");
new Dog("Barky Boy", "male", "small", 2, false, "img/barkyBoy.jpg","Mini Pinscher", "No");
new Dog("Doggo Escobar", "male", "medium", 12, false, "img/doggoEscobar.jpg","Shiba Inu", "No");



//Create Loop to display cards in HTML
let resultEl = document.getElementById("result") as HTMLElement;
//Put vaccineEl and vaccineIconEl as type any, because as HTMLCollection it wont accepts style property!
let vaccineEL:any = document.getElementsByClassName("vaccine-container");
let vaccineIconEL:any = document.getElementsByClassName("vaccine-icon");

function createCards() {
    resultEl.innerHTML = ``;
    for (let i in arrAnimals) {
        resultEl.innerHTML += arrAnimals[i].displayFull();
        if (arrAnimals[i].vaccine == true) {
            vaccineEL[i].style.background = "rgb(185, 205, 206)";
            vaccineIconEL[i].setAttribute("src", "img/yes.png");
        } else {
            vaccineEL[i].style.background = "rgb(205, 121, 121)";
            vaccineIconEL[i].setAttribute("src", "img/no.png");
        }
    }
}

//Initialize Card Deck for the first time
createCards();

//Create sort Function
let ascend: boolean = false;
function sortAlgorithm() {
    if (ascend == false) {
        arrAnimals.sort(function(firstNumber, secondNumber) {
            return firstNumber.age - secondNumber.age;
        })
        ascend = true;
    } else {
        arrAnimals.sort(function(firstNumber, secondNumber) {
            return secondNumber.age - firstNumber.age;
        })
        ascend = false;
    }
}

// //Add Eventlistener for Sort Button
document.getElementsByClassName("age-sort")[0].addEventListener("click", function() {
    sortAlgorithm();
    createCards();
})
