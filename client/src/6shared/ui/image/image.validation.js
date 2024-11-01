

function checkAspectRatio(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        
        img.onload = function() {
            const aspectRatio = this.width / this.height;
            if (aspectRatio >= 1.7 && aspectRatio <= 1.84) {
                resolve(img.src = url);
            } else {
                reject(new Error('A imagem está fora do padrão.'));
            }
        };

        img.onerror = function() {
            reject(new Error('Falha ao carregar a imagem.'));
        };

    });
}