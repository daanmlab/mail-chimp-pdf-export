

var app = new Vue({
    el: '#inputBox',
    data: {
        input: '',
        loader: false
    },

    methods: {
        generate: async function () {
            this.loader = true;
            fetch(`http://localhost:4000/getLink.php`, {
                method: 'POST',
                body: JSON.stringify({
                    link: this.input
                })
            }).then(async response => {

                let htmlString = (await response.json()).htmlString
                let element = document.createElement('div');
                element.innerHTML = htmlString;

                let newsLetter = element.querySelector('#bodyTable')

                let images = newsLetter.querySelectorAll('img')

                for (const image of images) {
                    let response = await fetch(`http://localhost:4000/getImage.php`, {
                        method: 'POST',
                        body: JSON.stringify({
                            link: image.src
                        })
                    })

                    let base64ImgSrc = (await response.json()).base64ImgSrc
                    image.src = base64ImgSrc;
                }

                console.log(newsLetter)

                var opt = {
                    margin: 1,
                    filename: 'userCard.pdf',
                    image: { type: 'jpg', quality: 0.99 },
                    html2canvas: { dpi: 192, letterRendering: true, useCORS: true },
                    jsPDF: {
                        unit: 'pt', format: 'letter', orientation: 'portrait'
                    }
                };

                var worker = await html2pdf().from(newsLetter).set(opt).save();

                this.loader = false;
            })
        }
    }
})