import React, { useState } from 'react';
import { 
  CaretSortIcon, CheckIcon, CalendarIcon, EnvelopeClosedIcon,
  FaceIcon, GearIcon, PersonIcon, RocketIcon
} from "@radix-ui/react-icons";
import { createFileRoute } from '@tanstack/react-router';
import { 
  Collapsible, CollapsibleContent, CollapsibleTrigger 
} from "@breeze/ui/collapsible";
import { 
  Popover, PopoverContent, PopoverTrigger 
} from '@breeze/ui/popover';
import { 
  Button, Command, CommandEmpty, CommandGroup, CommandInput, 
  CommandItem, CommandList, CommandSeparator, CommandShortcut, 
  ContextMenu, ContextMenuCheckboxItem, ContextMenuContent, 
  ContextMenuItem, ContextMenuLabel, ContextMenuRadioGroup, 
  ContextMenuRadioItem, ContextMenuSeparator, ContextMenuShortcut, 
  ContextMenuSub, ContextMenuSubContent, ContextMenuSubTrigger, 
  ContextMenuTrigger, cn 
} from '@breeze/ui';


// Define the main component
export const Route = createFileRoute('/')({
  component: () => {
    // State variables
    const [isOpen, setIsOpen] = useState(false);
    const [open, setOpen] = useState(false);
    const [value, setValue] = useState("");

    // Toggle function for collapsible component
    const toggleCollapsible = () => {
      setIsOpen(!isOpen);
    };

    // JSX rendering
    return (
      <>
        {/* Collapsible component */}
        <Collapsible className="w-full max-w-md mx-auto mt-10">
          <CollapsibleTrigger className="flex items-center justify-between bg-gray-200 hover:bg-gray-300 p-3 rounded-t" onClick={toggleCollapsible}>
            <span>What is Breeze about?</span>
            <span className={`inline-block ml-2 transform ${isOpen ? 'rotate-180' : ''}`}>&darr;</span>
          </CollapsibleTrigger>
          {isOpen && (
            <CollapsibleContent className="bg-white p-3 rounded-b shadow-md">
              Breeze is an event planning app...
            </CollapsibleContent>
          )}
        </Collapsible>

        {/* Combobox component */}
        <Popover open={open} onOpenChange={setOpen}>
          <PopoverTrigger asChild>
            <Button variant="solid" color="indigo" className="w-[200px] justify-between shadow-md">
              {value ? sectors.find((framework) => framework.value === value)?.label : "Select targeted sector..."}
              <CaretSortIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
          </PopoverTrigger>
          <PopoverContent className="w-[200px] p-0 shadow-md">
            {/* Command component */}
            <Command>
              <CommandInput placeholder="Search sector..." className="h-9" />
              <CommandEmpty>Nothing found.</CommandEmpty>
              <CommandGroup>
                {sectors.map((framework) => (
                  <CommandItem
                    key={framework.value}
                    value={framework.value}
                    onSelect={(currentValue) => {
                      setValue(currentValue === value ? "" : currentValue);
                      setOpen(false);
                    }}
                    className="flex items-center justify-between px-4 py-2 hover:bg-gray-100"
                  >
                    <span>"{framework.label}"</span>
                    <CheckIcon className={cn("h-4 w-4", value === framework.value ? "opacity-100" : "opacity-0")} />
                  </CommandItem>
                ))}
              </CommandGroup>
            </Command>
          </PopoverContent>
        </Popover>

        {/* Command component */}
        <Command className="rounded-lg border shadow-md">
          <CommandInput placeholder="Type a command or search..." />
          <CommandList>
            <CommandEmpty>No results found.</CommandEmpty>
            <CommandGroup heading="Suggestions">
              <CommandItem>
                <CalendarIcon className="mr-2 h-4 w-4" />
                <span>Calendar</span>
              </CommandItem>
              <CommandItem>
                <FaceIcon className="mr-2 h-4 w-4" />
                <span>Search Emoji</span>
              </CommandItem>
              <CommandItem>
                <RocketIcon className="mr-2 h-4 w-4" />
                <span>Launch</span>
              </CommandItem>
            </CommandGroup>
            <CommandSeparator />
            <CommandGroup heading="Settings">
              <CommandItem>
                <PersonIcon className="mr-2 h-4 w-4" />
                <span>Profile</span>
                <CommandShortcut>⌘P</CommandShortcut>
              </CommandItem>
              <CommandItem>
                <EnvelopeClosedIcon className="mr-2 h-4 w-4" />
                <span>Mail</span>
                <CommandShortcut>⌘B</CommandShortcut>
              </CommandItem>
              <CommandItem>
                <GearIcon className="mr-2 h-4 w-4" />
                <span>Settings</span>
                <CommandShortcut>⌘S</CommandShortcut>
              </CommandItem>
            </CommandGroup>
          </CommandList>
        </Command>

        {/* Context Menu */}
        <ContextMenu>
          <ContextMenuTrigger className="flex h-[150px] w-[300px] items-center justify-center rounded-md border border-dashed text-sm">
            Right click here
          </ContextMenuTrigger>
          <ContextMenuContent className="w-64">
            <ContextMenuItem inset>
              Back
              <ContextMenuShortcut>⌘[</ContextMenuShortcut>
            </ContextMenuItem>
            <ContextMenuItem inset disabled>
              Forward
              <ContextMenuShortcut>⌘]</ContextMenuShortcut>
            </ContextMenuItem>
            <ContextMenuItem inset>
              Reload
              <ContextMenuShortcut>⌘R</ContextMenuShortcut>
            </ContextMenuItem>
            <ContextMenuSub>
              <ContextMenuSubTrigger inset>More Tools</ContextMenuSubTrigger>
              <ContextMenuSubContent className="w-48">
                <ContextMenuItem>
                  Save Page As...
                  <ContextMenuShortcut>⇧⌘S</ContextMenuShortcut>
                </ContextMenuItem>
                <ContextMenuItem>Create Shortcut...</ContextMenuItem>
                <ContextMenuItem>Name Window...</ContextMenuItem>
                <ContextMenuSeparator />
                <ContextMenuItem>Developer Tools</ContextMenuItem>
              </ContextMenuSubContent>
            </ContextMenuSub>
            <ContextMenuSeparator />
            <ContextMenuCheckboxItem checked>
              Show Bookmarks Bar
              <ContextMenuShortcut>⌘⇧B</ContextMenuShortcut>
            </ContextMenuCheckboxItem>
            <ContextMenuCheckboxItem>Show Full URLs</ContextMenuCheckboxItem>
            <ContextMenuSeparator />
            <ContextMenuRadioGroup value="pedro">
              <ContextMenuLabel inset>People</ContextMenuLabel>
              <ContextMenuSeparator />
              <ContextMenuRadioItem value="pedro">
                Pedro Duarte
              </ContextMenuRadioItem>
              <ContextMenuRadioItem value="colm">Colm Tuite</ContextMenuRadioItem>
            </ContextMenuRadioGroup>
          </ContextMenuContent>
        </ContextMenu>

        {/* Data table (if needed) */}
      </>
    );
  }
});

// Data for the combobox component
const sectors = [
  { value: "fun&food", label: "Fun & Food" },
  { value: "art&design", label: "Art & Design" },
  { value: "education", label: "Education" },
  { value: "technology", label: "Technology" },
  { value: "music", label: "Music" },
];
