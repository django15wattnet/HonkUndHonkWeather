

class ForecastPager
{
	#weatherContent
	#listOuter
	#btnBack
	#btnNext
	#idxVisible = 0;
	#idxMax;
	
	
	constructor()
	{
		this.#weatherContent = document.querySelector('.honkWeatherOuter .content')
		if (null === this.#weatherContent) {
			console.log('.honkWeatherOuter .content not found')
			return
		}
		
		this.#listOuter = this.#weatherContent.querySelector('.list')
		if (null === this.#listOuter) {
			console.log('.list not found')
			return
		}
		
		this.#btnBack = this.#weatherContent.querySelector('.back')
		if (null === this.#btnBack) {
			console.log('back button not found')
			return
		}
		
		this.#btnNext = this.#weatherContent.querySelector('.next')
		if (null === this.#btnNext) {
			console.log('next button not found')
			return
		}
		
		// Max. index of .forecastOuter DIVs
		this.#idxMax = parseInt(
			this.#listOuter.lastElementChild.getAttribute('data-idx')
		)
		if (NaN === this.#idxMax || 0 === this.#idxMax) {
			console.log('Can\'t get max. index')
			return
		}
		
		this.#btnBack.addEventListener('click', this.#onClickPage.bind(this))
		this.#btnNext.addEventListener('click', this.#onClickPage.bind(this))
		
		this.#btnBack.style.visibility = 'hidden'
		this.#listOuter.querySelector('[data-idx]').style.display='table'
	}
	
	
	#onClickPage(ev)
	{
		let add = -1;
		if (true === ev.target.classList.contains('next')) {
			add = 1;
		}
		
		this.#idxVisible += add
		
		this
			.#listOuter
			.querySelectorAll('[data-idx]')
			.forEach(
				(elem) => {
					if (this.#idxVisible == elem.getAttribute('data-idx')) {
						elem.style.display = 'table'
					} else {
						elem.style.display = 'none'
					}
				}
			)
		
		if (this.#idxVisible > 0) {
			this.#btnBack.style.visibility = 'visible'
		} else {
			this.#btnBack.style.visibility = 'hidden'
		}
		
		if (this.#idxVisible < this.#idxMax) 		{
			this.#btnNext.style.visibility = 'visible'
		} else {
			this.#btnNext.style.visibility = 'hidden'
		}
	}
}


document.addEventListener(
	'DOMContentLoaded', 
	(ev) => {
		window.forecatPage = new ForecastPager()
	}
)
