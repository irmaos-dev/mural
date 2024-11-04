export function ImageAspectRatioValidator (url: string, min:number, max:number): Promise<boolean>{

    return new Promise((resolve) => {
        const img = new Image();
        
        img.onload = function() {
            const aspectRatio = img.width / img.height;
            if (aspectRatio >= min && aspectRatio <= max) {
                resolve(true);
            } else {
                resolve(false);
            }
        };

        img.onerror = function() {
            resolve(false);
        };

        img.src = url;

    });
}
