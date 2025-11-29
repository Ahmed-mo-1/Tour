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

    
    
    


<div id="video-label-container" class="tag-popup hidden">
    <button id="close-tag" class="tag-popup-close">×</button>

    <div class="tag-popup-content">
        <h2 class="tag-title"></h2>
        <p class="tag-description"></p>
        <div class="tag-media"></div>
    </div>
</div>


    
    
    
    
    
    
    




