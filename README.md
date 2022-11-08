# BIWebAPI

The app is currently being hosted here: https://webapicodechallenge.tiiny.site/#

With Heroku running the php REST API. And remotemysql running the DB.

When you enter the app you will see the list of clients and the ability to search this list.

From here you can select the first dummy client and click the view policies button.

This will then take you to the next page with a new search bar and filter button, a create new policy button and the table of policies for the client.

To filter the clients, click the dropdown button and chose which filter you would like applied. (i.e. Policy Type)

Once chosen, type in what you would like to look for in the search bar. (i.e. Public Liabilty).

Once you have written out your query, click the search button to the right of the text input to execute the search.

Once the search has been executed the table below should now show only records matching your filter/search.

To clear the filter and show all the clients policies again, please click the 'x clear' button to the right of the search button and input.

To create a new policy for this client. Click the 'Create New Policy' button located under the filter/search bar.

This will bring up a modal with the fields defining a policy, please enter your desired policy details into each field.

In the final field you can select an exsisting customer, or select create a brand new one.

Selecting create a new customer renders two extra fields that define a customer, please fill these in before pressing the create button.

Once you have entered your button click the create button located on the bottom right of the popup modal, to cancel this action click the cancel button to its left.

Once the modal closes, if you clicked create, a new entry should appear at the bottom of table that matches the data you just inserted.

To Edit an exsisting policy, go to its entry in the table and find the 'Edit Policy' button as the last field on the right of each policy entry.

Clicking this should open a modal like the one for creating a new policy but all the fields are populated with the policy you have chosen to edit.

Edit any of the desired details as if entering a new policy, and click the button at the bottom right to save. Once saved the modal will dissappear and the entry on the list you just edited should now reflect the changes you just made.
