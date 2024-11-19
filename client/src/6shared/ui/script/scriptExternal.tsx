import * as React from "react";

function loadError(onError:any) {
  console.error(`Failed ${onError.target.src} didn't load correctly`);
}

interface InterfaceScript{src:string} 
export function Script({src}:InterfaceScript) {
  React.useEffect(() => {
    const LoadExternalScript = () => {
      const externalScript = document.createElement("script");
      externalScript.onerror = loadError;
      externalScript.id = "external";
      externalScript.async = true;
      externalScript.type = "text/javascript";
      externalScript.setAttribute("crossorigin", "anonymous");
      document.body.appendChild(externalScript);
      externalScript.src = src;
    };
    LoadExternalScript();
  }, []);

  return <></>; //eslint-disable-line 
}