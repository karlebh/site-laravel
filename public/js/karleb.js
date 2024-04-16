async function deleteImage(image) {
    const response = await axios.delete(`/image/${image.id}`);

    const imageToDelete = document.querySelector(`#image-${image.id}`);

    if (response.status === 200) {
        imageToDelete.parentElement.style.display = "none";
    }

    console.log(response);
}

function makeReply(parent_id) {
    const hiddenIput = document.querySelector(
        "#commentBox input[name=parent_id]"
    );
    hiddenIput.value = parent_id;
    console.log(hiddenIput);
}

function toggleNav() {
    const nav = document.getElementById("navMenu");
    if (nav.classList.contains("flex")) {
        nav.classList.replace("flex", "hidden");
    } else {
        nav.classList.replace("hidden", "flex");
    }
}
