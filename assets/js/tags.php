<script>

async function tags(mpSdk) {

	//disable default tags
	mpSdk.Mattertag.getData().then(tags => {
		tags.forEach(tag => {
			mpSdk.Tag.allowAction(tag.sid, {
				navigating: true,
				opening: false,
				docking: false
			});
		});
	})
	.catch(error => {
		console.error('Error modifying tags:', error);
	});

	/*
	mpSdk.Mattertag.getData().then(tags => {
		tags.forEach(item => {
			item.enabled = false;
		});
		console.log(tags);
	})
	.catch(error => {
		console.error('Error getting Mattertag data:', error);
	});
	*/

const popup = document.getElementById("video-label-container");
const titleEl = popup.querySelector(".tag-title");
const descEl = popup.querySelector(".tag-description");
const mediaEl = popup.querySelector(".tag-media");

function getMediaHTML(mediaSrc) {
    if (!mediaSrc) return "";

    // YouTube
    if (mediaSrc.includes("watch?v=")) {
        const url = mediaSrc.replace("watch?v=", "embed/");
        return `<iframe src="${url}" loading="lazy" allowfullscreen></iframe>`;
    }

    // Spotify Album
    if (mediaSrc.includes("com/album")) {
        const url = mediaSrc.replace("com/album", "com/embed/album");
        return `<iframe src="${url}" loading="lazy"></iframe>`;
    }

    // Default Image
    return `<img src="${mediaSrc}" loading="lazy">`;
}

function showTagPopup(tag) {
    titleEl.textContent = tag.label || "";
    descEl.textContent = tag.description || "";
	if(tag.sid == "dcpBCjdVdFn") {mediaEl.innerHTML = "hello"}
	else {mediaEl.innerHTML = getMediaHTML(tag.mediaSrc);}
    
    popup.classList.remove("hidden");

    document.getElementById("close-tag").onclick = () => {
        popup.classList.add("hidden");
        mpSdk.Tag.close(tag.sid);
    };
}

mpSdk.Tag.openTags.subscribe({
    prevState: { selected: null },

    async onChanged(newState) {
        const [selected = null] = newState.selected;

        if (selected === this.prevState.selected) return;

        if (!selected) {
            popup.classList.add("hidden");
        } else {
            const tags = await mpSdk.Mattertag.getData();
            const tag = tags.find(t => t.sid === selected);
            if (tag) showTagPopup(tag);
        }

        this.prevState = { ...newState, selected };
    }
});


    

}

</script>

<style>
#video-label-container {
    position: absolute;
    width: clamp(200px, 90%, 450px);
    top: 5%;
	inset-inline: 5%;
	background-color: rgba(0, 0, 0, 0.2);
	backdrop-filter: blur(30px);
	-webkit-backdrop-filter: blur(30px);
	border: 1px solid #ccc;
    color: white;
    padding: 40px 15px 20px;
    border-radius: 16px;
    z-index: 1000;
}

.close-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    border-radius: 50px;
	border: none
}

.close-tag:hover {
    background: #ddd;
}







.tag-popup {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
	
    height: fit-content;
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.25s, transform 0.25s;
    z-index: 999999;
}

.tag-popup.hidden {
    opacity: 0;
    transform: translateY(20px);
    pointer-events: none;
}

.tag-popup-close {
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    align-self: flex-end;
    line-height: 20px;
}

.tag-media iframe,
.tag-media img {
    width: 100%;
    height: 250px;
    border: none;
    border-radius: 16px;
}

</style>

    
    
    
    
    
    


<div id="video-label-container" class="tag-popup hidden">
    <button id="close-tag" class="tag-popup-close">×</button>

    <div class="tag-popup-content">
        <h2 class="tag-title"></h2>
        <p class="tag-description"></p>
        <div class="tag-media"></div>
    </div>
</div>


    
    
    
    
    
    
    




