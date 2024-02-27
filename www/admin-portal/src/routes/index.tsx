import { Button, DatePickerDemo, Dialog, DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger, 
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    ProfileForm,
  } from '@breeze/ui'
import { createFileRoute } from '@tanstack/react-router'

  

export const Route = createFileRoute('/')({
  component: () =><div className='flex flex-col gap-5 justify-center items-center min-h-screen'>
    <Dialog>
        <DialogTrigger className='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Open Dialog</DialogTrigger>
            <DialogContent>
                <DialogHeader>
                <DialogTitle>Are you absolutely sure?</DialogTitle>
                <DialogDescription>
                    This action cannot be undone. This will permanently delete your account
                    and remove your data from our servers.
                </DialogDescription>
                </DialogHeader>
        </DialogContent>
    </Dialog>

    <Drawer>
        <DrawerTrigger className='bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded'>Open Drawer</DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
            <DrawerTitle>Are you absolutely sure?</DrawerTitle>
            <DrawerDescription>This action cannot be undone.</DrawerDescription>
            </DrawerHeader>
            <DrawerFooter>
            <Button>Submit</Button>
            <DrawerClose>
                <Button variant="outline">Cancel</Button>
            </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>

    <DropdownMenu>
        <DropdownMenuTrigger className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>Open Dropdown</DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>My Account</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Profile</DropdownMenuItem>
            <DropdownMenuItem>Billing</DropdownMenuItem>
            <DropdownMenuItem>Team</DropdownMenuItem>
            <DropdownMenuItem>Subscription</DropdownMenuItem>
        </DropdownMenuContent>

    </DropdownMenu>

    <DatePickerDemo />

    <ProfileForm />


  </div> 

})