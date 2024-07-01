export const handleWarningNotification = (data) => {
    // Sound notification
    const audio = new Audio(WARNING_SOUND_URL);
    audio.play();
}

