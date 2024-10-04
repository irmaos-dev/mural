import { pathKeys } from "~6shared/lib/react-router";
import { sessionLib, useSessionStore } from "~6shared/session";

export function GoogleLogin() {

    const url_params = JSON.parse(decodeURIComponent(window.location.search.substring(1)).replace(/=([^&]+)\&/g, "=\"$1\",\n\r").replace(/(^|\r)([^=]+)=/g, "\"$2\":").replace(/^/, '{').replace(/$/, '}')) //eslint-disable-line

    const username = url_params.user.username; //eslint-disable-line

    const { setSession } = useSessionStore.getState();

    const session = sessionLib.transformUserDtoToSession(url_params);
    setSession(session);

    return window.location.replace(pathKeys.profile.byUsername({username}));
}