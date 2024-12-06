export function ImageAspectRatioValidator (url: string, min:number, max:number): Promise<boolean>{

    return new Promise((resolve) => {
        const img = new Image();
        
        img.onload = () => {
            const aspectRatio = img.width / img.height;
            if (aspectRatio >= min && aspectRatio <= max) {
                resolve(true);
            } else {
                resolve(false);
            }
        };

        img.onerror = () => {
            resolve(false);
        };

        img.src = url;

    });
}
