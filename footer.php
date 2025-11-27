<?php

	include_once get_template_directory() . '/assets/js/sdk.php';
	include_once get_template_directory() . '/assets/js/floors.php';

?>





<script>







	async function tags(mpSdk) {






/**/
mpSdk.Mattertag.getData().then(tags => {
tags.forEach(tag => {
mpSdk.Tag.allowAction(tag.sid, {
navigating: true,
opening: false,
docking: false
});
});
}).catch(error => {
console.error('Error modifying tags:', error);
});
/**/
    
    
    
    
    
    
    




    
    
    
    
    
    
    
/**/

mpSdk.Mattertag.getData().then(tags => {
    
    
    
        tags.forEach(item => {
  item.enabled = false;
   item.label = "teste";
});
    
    
    console.log('test', tags);
    

}).catch(error => {
    console.error('Error getting Mattertag data:', error);
});

/**/


// Fetch Mattertag data and display in a custom container
mpSdk.Mattertag.getData().then(tags => {
    tags.forEach(tag => {
        //console.log('Tag Label:', tag.label);

        // Replace mediaSrc links for embedding
        let vidurl = '';
        if (tag.mediaSrc.includes("watch?v=")) {
            vidurl = tag.mediaSrc.replace("watch?v=", "embed/");
        } else if (tag.mediaSrc.includes("com/album")) {
            vidurl = tag.mediaSrc.replace("com/album", "com/embed/album");
        }

        // Dynamically update a custom HTML container with tag details
/*        document.querySelector('.food-slideup-container').innerHTML += `
            ${tag.label}<br>${tag.description}<br>
            <embed src="${vidurl}" width="100%" height="200"></embed><br><br>
        `;
        */
        //console.log('Tag Description:', tag.description);
        //console.log('Tag Media Source:', tag.mediaSrc);
    });
}).catch(error => {
    console.error('Error getting Mattertag data:', error);
});

// Create a fixed container for video label display
const videotest = document.createElement('div');
videotest.id = 'video-label-container';
videotest.style.position = 'absolute';
videotest.style.width = "clamp(200px, 90%, 550px)";
videotest.style.top = '5%';
videotest.style.left = '5%';
videotest.style.right = '5%';
videotest.style.backgroundColor = 'rgba(0,0,0,0.7)';
videotest.style.color = 'white';
videotest.style.padding = '80px 30px 40px';
videotest.style.borderRadius = '16px';
videotest.style.zIndex = '1000';
videotest.style.display = 'none'; // Initially hidden
document.getElementById('container').appendChild(videotest);

// Subscribe to tag changes and update video-label-container on selection
mpSdk.Tag.openTags.subscribe({
    prevState: {
        hovered: null,
        docked: null,
        selected: null,
    },
    onChanged(newState) {

        if (newState.hovered !== this.prevState.hovered) {
            if (newState.hovered) {
                console.log(newState.hovered, 'was hovered');
            } else {
                console.log(this.prevState.hovered, 'is no longer hovered');
            }
        }
        if (newState.docked !== this.prevState.docked) {
            if (newState.docked) {
                console.log(newState.docked, 'was docked');
            } else {
                console.log(this.prevState.docked, 'was undocked');
            }
        }

        // Handle selected tags
        const [selected = null] = newState.selected;
        if (selected !== this.prevState.selected) {
            if (selected) {
                console.log(selected, 'was selected');

                // Fetch the Mattertag data for the selected tag
                mpSdk.Mattertag.getData().then(tags => {
                    const selectedTag = tags.find(tag => tag.sid === selected);

                    if (selectedTag) {
                        

                        
/*
                        console.log('Selected Tag Info:');
                        console.log('Label:', selectedTag.label);
                        console.log('Description:', selectedTag.description);
                        console.log('Media Source:', selectedTag.mediaSrc);
*/
                        let vidurl = '';
                        let imgurl = '';
                        if (selectedTag.mediaSrc.includes("watch?v=")) {
                            vidurl = selectedTag.mediaSrc.replace("watch?v=", "embed/");
                        } else if (selectedTag.mediaSrc.includes("com/album")) {
                            vidurl = selectedTag.mediaSrc.replace("com/album", "com/embed/album");
                        }
						else{
						imgurl = selectedTag.mediaSrc;
						}

                        // Update the video-label-container with tag details
                        const videoContainer = document.getElementById('video-label-container');
                        if (selectedTag.mediaSrc.includes("watch?v=")){
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <iframe src="${vidurl}" width="100%" height="200" style="color-scheme: light; border-radius: 16px; border: none; height : 250px" loading="lazy" allowfullscreen></iframe><br><br>
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;


                        } else if (selectedTag.mediaSrc.includes("com/album")) {
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <iframe src="${vidurl}" width="100%" height="200" style="color-scheme: light; border-radius: 16px; border: none; height : 250px" loading="lazy" allowfullscreen></iframe><br><br>
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;
}

						else{
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <img src="${imgurl}" style="color-scheme: light; border-radius: 16px; border: none; width : 100%" loading="lazy">
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;
						}



const closeTags = document.getElementsByClassName('close-tag');
for (let i = 0; i < closeTags.length; i++) {
  closeTags[i].onclick = () => {
    videoContainer.style.display = 'none';
    mpSdk.Tag.close(selectedTag.sid);
  };
}
                        videoContainer.style.display = 'block';
                    }
                }).catch(error => {
                    console.error('Error fetching Mattertag data for selected tag:', error);
                });
            } else {
                console.log(this.prevState.selected, 'was deselected');
                // Hide the video-label-container when no tag is selected
                document.getElementById('video-label-container').style.display = 'none';
            }
        }

        // Clone and store the new state
        this.prevState = {
            ...newState,
            selected,
        };
    },
});

}
</script>



<?php
	wp_footer();
?>