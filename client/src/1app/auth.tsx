import { redirect } from "react-router-dom";
import { pathKeys } from "~6shared/lib/react-router";
import { sessionLib, useSessionStore } from "~6shared/session";

export function GoogleLogin() {

    const urlParams = JSON.parse(decodeURIComponent(window.location.search.substring(1)).replace(/=([^&]+)\&/g, "=\"$1\",\n\r").replace(/(^|\r)([^=]+)=/g, "\"$2\":").replace(/^/, '{').replace(/$/, '}')) //eslint-disable-line

    const { username } = urlParams.user;

    const { setSession } = useSessionStore.getState();

    const session = sessionLib.transformUserDtoToSession(urlParams);
    setSession(session);

    redirect(pathKeys.profile.byUsername({ username }));
}