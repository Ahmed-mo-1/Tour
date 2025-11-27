
<script>



	async function printFloorsData(mpSdk) {

		await mpSdk.Floor.showAll()
		  .then(function(){
			// Show floors complete.
		  })
		  .catch(function(error) {
			// Error displaying all floors.
		  });


		await mpSdk.Floor.getData()
		  .then(function(floors) {
			// Floor data retreival complete.
			console.log('Current floor: ' + floors.currentFloor);
			console.log('Total floors: ' + floors.totalFloors);
			console.log('Name of first floor: ' + floors.floorNames[0]);
		  })
		  .catch(function(error) {
			// Floors data retrieval error.
		  });


		await  mpSdk.Floor.current.subscribe(function (currentFloor) {
		  // Change to the current floor has occurred.
		  if (currentFloor.sequence === -1) {
			console.log('Currently viewing all floors');
		  } else if (currentFloor.sequence === undefined) {
			if (currentFloor.id === undefined) {
			  console.log('Current viewing an unplaced unaligned sweep');
			} else {
			  console.log('Currently transitioning between floors');
			}
		  } else {
			console.log('Currently on floor', currentFloor.id);
			console.log('Current floor\'s sequence index', currentFloor.sequence);
			console.log('Current floor\'s name', currentFloor.name)
		  }
		});



		await mpSdk.Floor.data.subscribe({
		  onCollectionUpdated: function (collection) {
			console.log('Collection received. There are ', Object.keys(collection).length, 'floors in the collection');
		  }
		});

	}

	async function printFloorsData2(mpSdk) {
		await mpSdk.Pointer.intersection.subscribe(function (intersectionData) {
			mpSdk.Pointer.setVisible(false);
		});
		await mpSdk.Settings.update('features/sweep_pucks', false);
		//await mpSdk.Settings.update('floor_plan', true);
	}



async function changeFloor(mpSdk) {
    try {
        // Get all floors
        const floorData = await mpSdk.Floor.getData();
        const totalFloors = floorData.totalFloors;
        const currentIndex = floorData.currentFloor;

        if (totalFloors === 0) {
            console.warn("No floors available");
            return;
        }

        // Calculate next floor index (wrap around)
        const nextIndex = (currentIndex + 1) % totalFloors;

        // Switch to the next floor using Floor.moveTo()
        await mpSdk.Floor.moveTo(nextIndex);

        console.log(`Changed floor to index: ${nextIndex}, name: ${floorData.floorNames[nextIndex]}`);
    } catch (error) {
        console.error("Error changing floor:", error);
    }
}



</script>